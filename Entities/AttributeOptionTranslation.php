<?php

namespace Modules\Attribute\Entities;

use Illuminate\Database\Eloquent\Model;

class AttributeOptionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'label'
    ];
    protected $table = 'attribute__attribute_option_translations';
}
