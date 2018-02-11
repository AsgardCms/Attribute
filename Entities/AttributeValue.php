<?php

namespace Modules\Attribute\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

final class AttributeValue extends Model
{
    use Translatable;

    protected $table = 'attribute__attribute_values';
    public $translatedAttributes = [];
    protected $fillable = [
        'content'
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function entity()
    {
        return $this->morphTo();
    }

    /**
     * @param string $content
     * @return array|mixed
     */
    public function getContentAttribute($content)
    {
        if($this->attribute->has_translatable_values) {
            return $this->translations->content;
        }
        return $content;
    }
}
