<?php

namespace Modules\Attribute\Repositories\Eloquent;

use Modules\Attribute\Repositories\AttributeRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentAttributeRepository extends EloquentBaseRepository implements AttributeRepository
{
    public function create($data)
    {
        $this->normalise($data);

        return $this->model->create($data);
    }

    public function update($attribute, $data)
    {
        $this->normalise($data);

        $attribute->update($data);

        return $attribute;
    }

    /**
     * Find all enabled attributes by the given namespace
     * @param string $namespace
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByNamespace($namespace)
    {
        return $this->model
            ->where('is_enabled', true)
            ->where('namespace', $namespace)
            ->where('has_translatable_values', false)
            ->with('translations')->get();
    }

    /**
     * Find all enabled attributes by the given namespace that have translatable values
     * @param string $namespace
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findTranslatableByNamespace($namespace)
    {
        return $this->model
            ->where('is_enabled', true)
            ->where('namespace', $namespace)
            ->where('has_translatable_values', true)
            ->with('translations')->get();
    }

    private function normalise(array &$data)
    {
        $data['key'] = str_slug($data['key']);

        unset($data['options']['count']);

        $data['options'] = $this->formatOptions(array_get($data, 'options'));
    }

    private function formatOptions(array $options)
    {
        $cleaned = [];

        foreach ($options as $key => $option) {
            $value = $option['value'];
            unset($option['value']);
            foreach ($option as $locale => $item) {
                $cleaned[$value][$locale]['label'] = $item['label'];
            }
        }

        return $cleaned;
    }
}
