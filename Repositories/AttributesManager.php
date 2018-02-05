<?php

namespace Modules\Attribute\Repositories;

use Modules\Attribute\Contracts\AttributesInterface;
use Modules\Attribute\Contracts\TypeInterface;
use Modules\Attribute\Entities\Attribute;

interface AttributesManager
{
    /**
     * Returns all the registered entity namespaces.
     * @return array
     */
    public function getNamespaces();

    /**
     * Returns all the registered entity.
     * @return array
     */
    public function getEntities();

    /**
     * Registers an entity namespace.
     * @param AttributesInterface $entity
     * @return void
     */
    public function registerEntity(AttributesInterface $entity);

    /**
     * Return all registered types
     * @return array
     */
    public function getTypes();

    /**
     * @param TypeInterface $type
     * @return void
     */
    public function registerType(TypeInterface $type);

    /**
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
}
