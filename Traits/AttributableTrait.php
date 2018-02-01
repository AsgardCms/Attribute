<?php

namespace Modules\Attribute\Traits;

use Illuminate\Database\Eloquent\Model;
use Modules\Attribute\Entities\Attribute;
use Modules\Attribute\Entities\AttributeValue;

trait AttributableTrait
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
     * {@inheritdoc}
     */
    public function attributes()
    {
        return static::createAttributesModel()->where('namespace', $this->getEntityNamespace());
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
     * @param  string  $key   Attribute Key
     * @param  string|null  $value Value (Use this variable when checking collectioin type value saved)
     * @return array|null
     */
    public function findAttributeValue($key, $value = null)
    {
        return $this->values()
                    ->when(!is_null($value), function ($query) use ($value) {
                        return $query->where('content', $value);
                    })
                    ->whereHas('attribute', function($query) use ($key) {
                        $query->where('key', $key);
                    })
                    ->first();
    }

    /**
     * Get AttributeValue's content directly (supports translation option)
     * @param  [type] $key    [description]
     * @param  [type] $locale [description]
     * @return [type]         [description]
     */
    public function findAttributeValueContent($key, $locale = null)
    {
        if($attributeValue = $this->findAttributeValue($key)) {
            if($locale) {
                return $attributeValue->hasTranslation($locale) ? $attributeValue->getTranslation($locale)->content : '';
            }
            return $attributeValue->content;
        }
        return null;
    }

    public function setAttributes(array $attributes = [])
    {
        foreach ($attributes as $key => $contents) {
            if(is_null($contents)) continue;
            // Find attribute by its key
            $attribute = $this->attributes()->where('key', $key)->first();
            // If attribute doesn't exist, reject saving
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
}
