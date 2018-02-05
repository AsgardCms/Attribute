<?php

namespace Modules\Attribute\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

final class AttributeOption extends Model
{
    use Translatable;

    protected $table = 'attribute__attribute_options';
    public $translatedAttributes = [
        'label'
    ];
    protected $fillable = [
        'key'
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function getLabel($locale = null)
    {
        $locale = $locale ? $locale : locale();
        return $this->hasTranslation($locale) ? $this->translate($locale)->label : $this->key;
    }

}
