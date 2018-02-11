<?php

namespace Modules\Attribute\Entities;

use Illuminate\Database\Eloquent\Model;

class AttributeValueTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['content'];
    protected $table = 'attribute__attribute_value_translations';
}
