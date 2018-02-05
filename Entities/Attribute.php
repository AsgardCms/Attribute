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
        'slug',
        'namespace',
        'type',
        'has_translatable_values',
        'is_enabled',
        'is_system',
    ];
    protected $appends = [
        'options'
    ];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function options()
    {
        return $this->hasMany(AttributeOption::class);
    }

    /**
     * @param $options
     */
    public function setOptions($options)
    {
        $inserted_ids = [];
        foreach ($options as $key => $values) {
            if($key) {
                $values['key'] = $key;
                $option = $this->options()->where('key', $key)->first();
                if($option) {
                    $option->fill($values);
                    $option->save();
                }
                else $option = $this->options()->create($values);
                $inserted_ids[] = $option->getKey();
            }
        }

        $this->options()->whereNotIn('id', $inserted_ids)->delete();
    }

    /**
     * @param $options
     * @return array|mixed
     */
    public function getOptionsAttribute($options)
    {
        return $this->options()->with('translations')->get()->keyBy('key');
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

    /**
     * Check if the current attributes has options
     * @return bool
     */
    public function getEntityName()
    {
        $namespaces = app(AttributesManager::class)->getEntities();
        return isset($namespaces[$this->namespace]) ? $namespaces[$this->namespace]->getEntityName() : $this->namespace;
    }

}
