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
     * Returns a human friendly name for the type.
     * @return string
     */
    public function getEntityName();

    /**
     * Check if this entitiy has translatable Attribute.
     * @var int
     */
    public function hasTranslatableAttribute();

    /**
     * Create system attributes if not exists
     */
    public function createSystemAttributes();

}
