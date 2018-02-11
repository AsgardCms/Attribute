<?php

namespace Modules\Attribute\Contracts;

interface AttributesInterface
{
    /**
     * The Eloquent attribute entity name.
     * @var string
     */
    public static function getEntityNamespace();
    
    /**
     * Check if this entitiy has translatable Attribute.
     * @var int
     */
    public function hasTranslatableAttribute();
}
