<?php

namespace Modules\Attribute\Repositories;

use Modules\Attribute\Contracts\AttributesInterface;
use Modules\Attribute\Contracts\TypeInterface;
use Modules\Attribute\Entities\Attribute;

final class AttributesManagerRepository implements AttributesManager
{
    /**
     * Array of registered namespaces.
     * @var array
     */
    private $namespaces = [];

    /**
     * Array of registered types.
     * @var array
     */
    private $types = [];

    /**
     * Returns all the registered namespaces.
     * @return array
     */
    public function getNamespaces()
    {
        return $this->namespaces;
    }

    /**
     * Registers an entity namespace.
     * @param AttributesInterface $entity
     * @return void
     */
    public function registerNamespace(AttributesInterface $entity)
    {
        $this->namespaces[] = $entity->getEntityNamespace();
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
