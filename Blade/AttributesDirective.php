<?php

namespace Modules\Attribute\Blade;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
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

        $this->entity->createSystemAttributes();

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
        $translatableForm = '';

        $normalAttributes = $attributes->where('has_translatable_values', false);
        $translatableAttributes = $attributes->where('has_translatable_values', true);

        foreach ($normalAttributes as $attribute) {
            $form .= $this->attributesManager->getEntityFormField($attribute, $entity);
        }

        foreach ($translatableAttributes as $attribute) {
            foreach(LaravelLocalization::getSupportedLanguagesKeys() as $i => $locale) {
                $active = locale() == $locale ? 'active' : '';
                $translatableForm .= "<div class='tab-pane $active' id='tab_attributes_$i'>";
                $translatableForm .= $this->attributesManager->getTranslatableEntityFormField($attribute, $entity, $locale);
                $translatableForm .= '</div>';
            }
        }

        return view($view, compact('entity', 'form', 'translatableForm'));
    }
}
