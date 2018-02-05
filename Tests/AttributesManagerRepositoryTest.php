<?php

namespace Modules\Attribute\Tests;

use Modules\Attribute\Contracts\AttributesInterface;
use Modules\Attribute\Repositories\AttributesManagerRepository;
use Modules\Attribute\Types\InputType;

final class AttributesManagerRepositoryTest extends BaseTestCase
{
    /**
     * @var AttributesManagerRepository
     */
    private $attributesManager;

    public function setUp()
    {
        parent::setUp();

        $this->attributesManager = new AttributesManagerRepository();
    }

    /** @test */
    public function it_initialises_empty_entities_array()
    {
        $this->assertEquals([], $this->attributesManager->getEntities());
    }

    /** @test */
    public function it_adds_items_to_array()
    {
        $this->attributesManager->registerEntity(new TestModel());

        $this->assertCount(1, $this->attributesManager->getEntities());
    }

    /** @test */
    public function it_initialises_empty_types_array()
    {
        $this->assertEquals([], $this->attributesManager->getTypes());
    }

    /** @test */
    public function it_adds_a_type()
    {
        $this->attributesManager->registerType(new InputType());

        $this->assertCount(1, $this->attributesManager->getTypes());
    }
}

class TestModel implements AttributesInterface
{
    use \Modules\Core\Traits\NamespacedEntity;
    protected static $entityNamespace = 'asgardcms/page';

    public function hasTranslatableAttribute()
    {
        return false;
    }

    public function getEntityName()
    {
        return '';
    }

    public function createSystemAttributes() { }
}
