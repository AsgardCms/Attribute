<?php

namespace Modules\Attribute\Contracts;

interface AttributesInterface
{
    /**
     * The Eloquent attribute entity name.
     * @var string
     */
    public static function getEntityNamespace();
}
