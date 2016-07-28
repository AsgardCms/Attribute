<?php

namespace Modules\Attribute\Blade;

use Modules\Attribute\Contracts\AttributesInterface;
use Modules\Attribute\Repositories\AttributeRepository;
use Modules\Attribute\Repositories\AttributesManager;

final class TranslatableAttributesDirective
{
    /**
     * @var string
     */
    private $namespace;
    /**
     * @var AttributesInterface
     */
    private $entity;
    /**
     * @var AttributeRepository
     */
    private $attribute;
    /**
     * @var AttributesManager
     */
    private $attributesManager;
    /**
     * @var string
     */
    private $locale;

    public function __construct(AttributeRepository $attribute, AttributesManager $attributesManager)
    {
        $this->attribute = $attribute;
        $this->attributesManager = $attributesManager;
    }

    public function show($arguments)
    {
        $this->extractArguments($arguments);

        $attributes = $this->attribute->findTranslatableByNamespace($this->namespace);

        return $this->renderForm($this->entity, $attributes);
    }

    /**
     * Extract the possible arguments as class properties
     * @param array $arguments
     */
    private function extractArguments(array $arguments)
    {
        $this->namespace = array_get($arguments, 0);
        $this->entity = array_get($arguments, 1);
        $this->locale = array_get($arguments, 2);
    }

    private function renderForm(AttributesInterface $entity, $attributes = [], $view = null)
    {
        $namespace = $this->namespace;
        $locale = $this->locale;
        $view = $view ?: 'attribute::admin.blade.translatable-form';

        $form = '';

        foreach ($attributes as $attribute) {
            $form .= $this->attributesManager->getTranslatableEntityFormField($attribute, $entity, $locale);
        }

        return view($view, compact('namespace', 'form', 'locale'));
    }
}
