<?php

namespace Modules\Attribute\Repositories\Eloquent;

use Modules\Attribute\Facades\OptionsNormaliser;
use Modules\Attribute\Repositories\AttributeRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentAttributeRepository extends EloquentBaseRepository implements AttributeRepository
{
    public function create($data)
    {
        $data['slug'] = str_slug($data['slug']);

        $data['options'] = OptionsNormaliser::normalise(array_get($data, 'options'));

        $attribute = $this->model->create($data);

        $attribute->setOptions(array_get($data,'options',[]));

        return $attribute;
    }

    public function update($attribute, $data)
    {
        $data['slug'] = str_slug($data['slug']);

        $data['options'] = OptionsNormaliser::normalise(array_get($data, 'options'));

        $attribute->update($data);

        $attribute->setOptions(array_get($data,'options',[]));

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
            ->with('translations')->get();
    }

}
