<?php

namespace Modules\Attribute\Blade\Facades;

use Illuminate\Support\Facades\Facade;

final class TranslatableAttributesDirective extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'attribute.translatable.attributes.directive';
    }
}
