<?php

namespace Modules\Attribute\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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
    public function values()
    {
        return $this->morphMany(AttributeValue::class, 'entity');
    }

    /**
     * {@inheritdoc}
     */
    public static function createAttributesModel()
    {
        return new static::$attributesModel;
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
                    ->when($value, function ($query) use ($value) {
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
            // Find attribute by its key and namespace
            $attribute = static::createAttributesModel()
                                    ->where('key', $key)
                                    ->where('namespace', $this->getEntityNamespace())
                                    ->first();
            // If attribute doesn't exist, reject saving
            if ($attribute === null) {
                continue;
            }

            // Remove if model has the attribute value already
            $this->values()->where('attribute_id', $attribute->id)->delete();

            // If attribute type is string
            if(in_array($attribute->type, ['input', 'textarea'])) {
                // Check translatable
                if($attribute->has_translatable_values) {
                    // Saving translations of AttributeValue
                    $data = array();
                    foreach($contents as $locale => $content) {
                        $data[$locale] = [ 'content' => $content ];
                    }
                    $this->createAttributeValue($attribute, $data);
                }
                else {
                    // Saving normal string type AttributeValue
                    $this->createAttributeValue($attribute, [
                        'content' => $contents
                    ]);
                }
            }
            else {
                // Treat as array if attribute type is Collection
                foreach($contents as $content) {
                    $this->createAttributeValue($attribute, [
                        'content' => $content
                    ]);
                }
            }
        }
    }

    public function createAttributeValue($attribute, array $data)
    {
        $attributeValue = $this->values()->create($data);
        $attributeValue->attribute_id = $attribute->id;
        $attributeValue->save();
    }
}
