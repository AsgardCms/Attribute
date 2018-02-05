<?php

namespace Modules\Attribute\Traits;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Attribute\Entities\Attribute;
use Modules\Attribute\Entities\AttributeValue;

trait Attributable
{
    /**
     * @var Model
     */
    protected static $attributesModel = Attribute::class;

    /**
     * {@inheritdoc}
     */
    public static function getAttributesModel()
    {
        return static::$attributesModel;
    }

    /**
     * {@inheritdoc}
     */
    public static function setAttributesModel($model)
    {
        static::$attributesModel = $model;
    }

    /**
     * {@inheritdoc}
     */
    public static function createAttributesModel()
    {
        return new static::$attributesModel;
    }

    /**
     * @inheritDoc
     */
    public function getEntityName()
    {
        return get_called_class();
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return static::createAttributesModel()->where('namespace', $this->getEntityNamespace())
                ->with(['values' => function($query) {
                    $query->where('entity_type', static::class);
                    $query->where('entity_id', static::getKey());
                }]);
    }

    /**
     * {@inheritdoc}
     */
    public function values()
    {
        return $this->morphMany(AttributeValue::class, 'entity');
    }

    /**
     * Get attribute's value (or check if value exists)
     * @param  string  $slug   Attribute Key
     * @param  string|null  $value Value (Use this variable when checking collectioin type value saved)
     * @return array|null
     */
    public function findAttributeValue($slug, $value = null)
    {
        return $this->values()
                    ->when(!is_null($value), function ($query) use ($value) {
                        return $query->where('content', $value);
                    })
                    ->whereHas('attribute', function($query) use ($slug) {
                        $query->where('slug', $slug);
                    })
                    ->first();
    }

    /**
     * Get AttributeValue's content directly (supports translation option)
     * @param  string $slug
     * @param  string $locale
     * @return string
     */
    public function findAttributeValueContent($slug, $locale = null)
    {
        if($attributeValue = $this->findAttributeValue($slug)) {
            if($locale) {
                return $attributeValue->hasTranslation($locale) ? $attributeValue->getTranslation($locale)->content : '';
            }
            return $attributeValue->content;
        }
        return null;
    }

    /**
     * Set Attributes
     * @param array $attributes
     */
    public function setAttributes(array $attributes = [])
    {
        foreach ($attributes as $slug => $contents) {
            if(empty($slug) || empty($contents)) continue;
            // Find attribute by its key
            $attribute = $this->attributes()->where('slug', $slug)->first();
            // If attribute doesn't exist, check if it is dynamicAttribute
            if ($attribute === null) {
                continue;
            }

            // Get every values related to this attribute
            $values = $this->values()->where('attribute_id', $attribute->id);

            // If attribute type is string
            if($attribute->useOptions()) {
                // Treat as array if attribute type is Collection
                if($attribute->isCollection()) {
                    // Apply collection AttributeValue and remove rest of them
                    $appliedIds = array();
                    foreach($contents as $content) {
                        $value = $this->createAttributeValue($attribute, [
                            'content' => $content
                        ]);
                        $appliedIds[] = $value->getKey();
                    }
                    $values->whereNotIn('id', $appliedIds)->delete();
                }
                else {
                    $data = [ 'content' => $contents ];
                    // Apply to first AttributeValue and remove rest of them
                    if($value = $values->first()) {
                        $value->fill($data);
                        $value->save();
                    }
                    else $value = $this->createAttributeValue($attribute, $data);

                    $values->whereNotIn('id', [$value->getKey()])->delete();
                }
            }
            else {
                $data = array();
                // Check translatable
                // (This function should work only for String Type - Input, Textarea)
                if($attribute->has_translatable_values) {
                    // Rearrange structure of Translated Data
                    foreach($contents as $locale => $content) {
                        $data[$locale] = [ 'content' => $content ];
                    }
                }
                else $data = [ 'content' => $contents ];

                // Apply to first AttributeValue and remove rest of them
                if($value = $values->first()) {
                    $value->fill($data);
                    $value->save();
                }
                else $value = $this->createAttributeValue($attribute, $data);

                $values->whereNotIn('id', [$value->getKey()])->delete();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeAttributes()
    {
        return $this->values()->delete();
    }

    /**
     * Helper method to create AttributeValue
     * @param  Attribute $attribute
     * @param  array  $data
     * @return AttributeValue
     */
    public function createAttributeValue($attribute, array $data)
    {
        $value = new AttributeValue($data);
        $value->attribute_id = $attribute->id;
        $this->values()->save($value);
        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function hasTranslatableAttribute()
    {
        return $this->attributes()->where('has_translatable_values', true)->count();
    }

    /**
     * {@inheritdoc}
     */
    public static function getSystemAttributes()
    {
        return isset(static::$systemAttributes) ? collect(static::$systemAttributes) : collect([]);
    }

    /**
     * {@inheritdoc}
     */
    public function createSystemAttributes()
    {
        $systemAttributes = $this::getSystemAttributes();
        $attributes = $this->attributes()->get()->keyBy('slug');
        $systemAttributeIds = [];
        foreach ($systemAttributes as $slug => $config) {
            $config = collect($config);
            if(!$slug || !$config->has('type')) continue;
            // If attributes is not in database
            if(isset($attributes[$slug])) {
                $attribute = $attributes[$slug];
                $attribute->type = $config->get('type');
                $attribute->has_translatable_values = $config->get('has_translatable_values', false);
                $attribute->save();
            }
            else {
                // Create Attribute based on system attribustes
                $attributeData = [
                    'namespace' => $this->getEntityNamespace(),
                    'slug' => $slug,
                    'type' => $config->get('type'),
                    'has_translatable_values' => $config->get('has_translatable_values', false),
                    'is_enabled' => true,
                    'is_system' => true,
                ];
                foreach (LaravelLocalization::getSupportedLanguagesKeys() as $locale) {
                    $attributeData[$locale]['name'] = $slug;
                }
                $attribute = new Attribute($attributeData);
                $attribute->save();
            }

            // Save Options
            if($options = $config->get('options')) {
                $optionData = [];
                foreach ($options as $key => $value) {
                    if(is_string($value)) {
                        $key = $value;
                        $value = [];
                    }
                    $optionData[$key] = $value;
                    foreach (LaravelLocalization::getSupportedLanguagesKeys() as $locale) {
                        if(!isset($optionData[$key][$locale]))
                            $optionData[$key][$locale]['label'] = $key;
                    }
                }
                $attribute->setOptions($optionData);
            }
            $systemAttributeIds[] = $attribute->getKey();
        }
        $this->attributes()->whereNotIn('id', $systemAttributeIds)->update(['is_system'=>false]);
    }

}
