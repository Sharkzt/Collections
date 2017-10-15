<?php

namespace Sharkzt\Collections\Tests\Collection;

use PHPUnit\Framework\TestCase;
use Mockery as m;
use Sharkzt\Collections\Collection\AbstractList;

/**
 * Class AbstractListTest
 */
class AbstractListTest extends TestCase
{
    /**
     * @var string
     */
    private $collectionClass;

    /**
     * @var AbstractList
     */
    private $abstractList;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this
            ->setCollectionClass();

        $this->abstractList = $this->getMockBuilder(AbstractList::class)
            ->setConstructorArgs([$this->collectionClass])
            ->getMockForAbstractClass();
    }

    /**
     * @return void
     */
    public function testIndexOfReturnInteger(): void
    {
        $element = new \stdClass();
        $this
            ->setClassProperty('position', 0)
            ->setClassProperty('array', [$element]);

        $this->assertEquals(0, $this->abstractList->indexOf($element));

        $this
            ->setClassProperty('position', 0)
            ->setClassProperty('array', [$element, new \stdClass()]);

        $this->assertEquals(0, $this->abstractList->indexOf($element));
        $this->assertEquals(-1, $this->abstractList->indexOf(new \stdClass()));
    }

    /**
     * @return void
     */
    public function testIndexOfThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $element = new \stdClass();
        $this
            ->setClassProperty('position', 1)
            ->setClassProperty('array', [$element]);

        $this->abstractList->indexOf(new \DateTime());
    }

    /**
     * @return void
     */
    public function testSetReturnThis(): void
    {
        $element = new \stdClass();
        $this->setClassProperty('position', 0);

        $this->assertEquals($this->abstractList, $this->abstractList->set($element, 0));
    }

    /**
     * @return void
     */
    public function testSetThrowsOutOfRangeException(): void
    {
        $this->expectException(\OutOfRangeException::class);

        $element = new \stdClass();
        $this->setClassProperty('position', 0);

        $this->abstractList->set($element, 1);
    }

    /**
     * @return void
     */
    public function testSetThrowsInvalidArgumentException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $element = new \DateTime();
        $this->setClassProperty('position', 0);

        $this->abstractList->set($element, 0);
    }

    /**
     * @return void
     */
    public function tearDown(): void
    {
        m::close();
    }

    /**
     * @return AbstractListTest
     */
    private function setCollectionClass(): AbstractListTest
    {
        $this->collectionClass = \stdClass::class;

        return $this;
    }

    /**
     * @param string $name
     * @param $parameters
     * @return AbstractListTest
     */
    private function setClassProperty(string $name, $parameters): AbstractListTest
    {
        $reflected = new \ReflectionClass($this->abstractList);
        $property = $reflected->getProperty($name);
        $property->setAccessible(true);
        $property->setValue($this->abstractList, $parameters);

        return $this;
    }
}
