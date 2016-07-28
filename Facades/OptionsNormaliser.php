<?php

namespace Modules\Attribute\Facades;

use Illuminate\Support\Facades\Facade;

final class OptionsNormaliser extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'options.normaliser';
    }
}
