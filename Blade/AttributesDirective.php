<?php

namespace Modules\Attribute\Blade;

use Modules\Attribute\Contracts\AttributesInterface;
use Modules\Attribute\Repositories\AttributeRepository;
use Modules\Attribute\Repositories\AttributesManager;

final class AttributesDirective
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

    public function __construct(AttributeRepository $attribute, AttributesManager $attributesManager)
    {
        $this->attribute = $attribute;
        $this->attributesManager = $attributesManager;
    }

    public function show($arguments)
    {
        $this->extractArguments($arguments);

        $attributes = $this->attribute->findByNamespace($this->namespace);

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
    }

    private function renderForm(AttributesInterface $entity, $attributes = [], $view = null)
    {
        $namespace = $this->namespace;
        $view = $view ?: 'attribute::admin.blade.form';

        $form = '';

        foreach ($attributes as $attribute) {
            $form .= $this->attributesManager->getEntityFormField($attribute, $entity);
        }

        return view($view, compact('namespace', 'form'));
    }
}
