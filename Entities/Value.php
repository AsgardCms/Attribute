<?php

namespace Modules\Attribute\Entities;

use Illuminate\Database\Eloquent\Model;

final class Value extends Model
{
    protected $table = 'attribute__attribute_values';

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function entity()
    {
        return $this->morphTo('entity');
    }
}
