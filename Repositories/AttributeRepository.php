<?php

namespace Modules\Attribute\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface AttributeRepository extends BaseRepository
{
    /**
     * Find all enabled attributes by the given namespace that don't have translatable values
     * @param string $namespace
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByNamespace($namespace);

    /**
     * Find all enabled attributes by the given namespace that have translatable values
     * @param string $namespace
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findTranslatableByNamespace($namespace);
}
