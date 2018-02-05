<?php

namespace Modules\Attribute\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface AttributeRepository extends BaseRepository
{
    /**
     * Find all enabled attributes by the given namespace
     * @param string $namespace
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByNamespace($namespace);

}
