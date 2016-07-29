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
        return $this->hasMany(Value::class);
    }

    /**
     * @param $options
     */
    public function setOptionsAttribute($options)
    {
        $this->attributes['options'] = count($options) > 1 ? json_encode($options) : '';
    }

    /**
     * @param $options
     * @return array|mixed
     */
    public function getOptionsAttribute($options)
    {
        return $options ? json_decode($options, true) : [];
    }

    /**
     * Check if the current attributes has options
     * @return bool
     */
    public function hasOptions()
    {
        $type = app(AttributesManager::class)->getTypes()[$this->type];

        return $type->allowOptions();
    }
}
