<?php

namespace Modules\Attribute\Contracts;

use Modules\Attribute\Entities\Attribute;

interface TypeInterface
{
    /**
     * Returns the type identifier.
     * @return string
     */
    public function getIdentifier();

    /**
     * Returns a human friendly name for the type.
     * @return string
     */
    public function getName();

    /**
     * Returns the HTML for creating / editing an entity.
     * @param Attribute $attribute
     * @param AttributesInterface $entity
     * @return string
     */
    public function getEntityFormField(Attribute $attribute, AttributesInterface $entity);

    /**
     * Returns the HTML for creating / editing an entity that has translatable values.
     * @param Attribute $attribute
     * @param AttributesInterface $entity
     * @param string $locale
     * @return string
     */
    public function getTranslatableEntityFormField(Attribute $attribute, AttributesInterface $entity, $locale);

    /**
     * Returns boolean for whether the type allows to use options.
     * @return bool
     */
    public function allowOptions();
}
