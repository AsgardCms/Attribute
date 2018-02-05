<?php

namespace Modules\Attribute\Repositories;

use Modules\Attribute\Contracts\AttributesInterface;
use Modules\Attribute\Contracts\TypeInterface;
use Modules\Attribute\Entities\Attribute;

final class AttributesManagerRepository implements AttributesManager
{
    /**
     * @var array
     */
    private $entities = [];

    /**
     * @var array
     */
    private $types = [];

    public function getNamespaces()
    {
        return array_keys($this->entities);
    }

    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * Registers an entity namespace.
     * @param AttributesInterface $entity
     * @return void
     */
    public function registerEntity(AttributesInterface $entity)
    {
        $this->entities[$entity->getEntityNamespace()] = $entity;
    }

    /**
     * Return all registered types
     * @return array
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param TypeInterface $type
     * @return void
     */
    public function registerType(TypeInterface $type)
    {
        $this->types[$type->getIdentifier()] = $type;
    }

    /**
     * @param Attribute $attribute
     * @param AttributesInterface $entity
     * @return string
     */
    public function getEntityFormField(Attribute $attribute, AttributesInterface $entity)
    {
        return $this->types[$attribute->type]->getEntityFormField($attribute, $entity);
    }

    /**
     * Returns the HTML for creating / editing an entity that has translatable values.
     * @param Attribute $attribute
     * @param AttributesInterface $entity
     * @param string $locale
     * @return string
     */
    public function getTranslatableEntityFormField(Attribute $attribute, AttributesInterface $entity, $locale)
    {
        return $this->types[$attribute->type]->getTranslatableEntityFormField($attribute, $entity, $locale);
    }
}
