<?php

namespace Modules\Attribute\Traits;

use Illuminate\Database\Eloquent\Builder;
use Modules\Attribute\Entities\Attribute;

trait AttributableTrait
{
    /**
     * {@inheritdoc}
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
        return $this->morphToMany(static::$attributesModel, 'entity', 'attribute__attribute_values', 'entity_id', 'attribute_id')
            ->withPivot('value')->withTimestamps();
    }

    /**
     * {@inheritdoc}
     */
    public static function createAttributesModel()
    {
        return new static::$attributesModel;
    }

    public function findAttribute($attribute)
    {
        dd($this->values()->attribute()->where('key', 'meta_title'));
        return $this->whereHas('values', function (Builder $query) {
            $query->where('attribute_id', 1);
//            $query->whereHas('attribute', function (Builder $query) {
//                $query->where('key', 'meta-title');
//            });
        })->first();
    }

    public function setAttributes(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            // Find attribute by its key
            $attribute = static::createAttributesModel()->where('key', $key)->first();
            if ($attribute === null) {
                continue;
            }
            // Check if model has the attribute already
            $this->values()->where('attribute_id', $attribute->id)->where('namespace', $this->getEntityNamespace())->first();
        }
    }
}
