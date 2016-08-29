<?php

namespace Modules\Attribute\Repositories\Cache;

use Modules\Attribute\Repositories\AttributeRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAttributeDecorator extends BaseCacheDecorator implements AttributeRepository
{
    public function __construct(AttributeRepository $attribute)
    {
        parent::__construct();
        $this->entityName = 'attribute.attributes';
        $this->repository = $attribute;
    }

    /**
     * Find all enabled attributes by the given namespace
     * @param string $namespace
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByNamespace($namespace)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.findByNamespace.{$namespace}", $this->cacheTime,
                function () use ($namespace) {
                    return $this->repository->findByNamespace($namespace);
                }
            );
    }

    /**
     * Find all enabled attributes by the given namespace that have translatable values
     * @param string $namespace
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findTranslatableByNamespace($namespace)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.findTranslatableByNamespace.{$namespace}", $this->cacheTime,
                function () use ($namespace) {
                    return $this->repository->findTranslatableByNamespace($namespace);
                }
            );
    }
}
