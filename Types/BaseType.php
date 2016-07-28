<?php

namespace Modules\Attribute\Types;

use Modules\Attribute\Contracts\AttributesInterface;
use Modules\Attribute\Contracts\TypeInterface;
use Modules\Attribute\Entities\Attribute;

abstract class BaseType implements TypeInterface
{
    /**
     * Name of the type.
     * @var string
     */
    protected $identifier;

    /**
     * Can this type have additional options.
     * @var bool
     */
    protected $allowOptions = false;

    /**
     * {@inheritDoc}
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return trans("attribute::attributes.types.{$this->identifier}");
    }

    /**
     * {@inheritDoc}
     */
    public function getEntityFormField(Attribute $attribute, AttributesInterface $entity)
    {
        return view("attribute::admin.types.normal.{$this->identifier}", compact('attribute', 'entity'));
    }

    /**
     * {@inheritDoc}
     */
    public function getTranslatableEntityFormField(Attribute $attribute, AttributesInterface $entity, $locale)
    {
        return view("attribute::admin.types.translatable.{$this->identifier}", compact('attribute', 'entity', 'locale'));
    }

    /**
     * {@inheritDoc}
     */
    public function allowOptions()
    {
        return $this->allowOptions;
    }
}
