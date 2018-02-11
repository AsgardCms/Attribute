<?php

namespace Modules\Attribute\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Attribute\Repositories\AttributesManager;

class Attribute extends Model
{
    use Translatable;

    protected $table = 'attribute__attributes';
    public $translatedAttributes = ['name', 'description'];
    protected $fillable = [
        'name',
        'description',
        'namespace',
        'key',
        'type',
        'options',
        'is_enabled',
        'has_translatable_values',
    ];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    /**
     * @param $options
     */
    public function setOptionsAttribute($options)
    {
        $filtered = collect($options)->filter(function ($value, $key) {
            return !!$key;
        });
        $this->attributes['options'] = $filtered->isNotEmpty() ? $filtered->toJson() : '';
    }

    /**
     * @param $options
     * @return array|mixed
     */
    public function getOptionsAttribute($options)
    {
        return $options ? json_decode($options, true) : [];
    }

    public function getTypeInstance()
    {
        $types = app(AttributesManager::class)->getTypes();
        return isset($types[$this->type]) ? $types[$this->type] : null;
    }

    /**
     * Check if the current attributes has options
     * @return bool
     */
    public function useOptions()
    {
        return $this->getTypeInstance()->useOptions();
    }
    
    /**
     * Check if the current attributes has options
     * @return bool
     */
    public function isCollection()
    {
        return $this->getTypeInstance()->isCollection();
    }

}
