<?php

namespace Sharkzt\Collections\Tests\Collection;

use PHPUnit\Framework\TestCase;
use Mockery as m;
use Sharkzt\Collections\Collection\ArrayList;

/**
 * Class ArrayListTest
 */
class ArrayListTest extends TestCase
{
    /**
     * @var ArrayList
     */
    private $arrayList;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->arrayList = new ArrayList(\stdClass::class);
    }

    /**
     * @return iterable
     */
    public function allElementsProvider(): iterable
    {
        return [
            [
                [new \stdClass()],
            ],
            [
                [new \stdClass(), new \stdClass()],
            ],
            [
                [new \stdClass(), new \stdClass(), new \stdClass()],
            ],
        ];
    }

    /**
     * @dataProvider allElementsProvider
     *
     * @param iterable $objects
     * @return void
     */
    public function testGetWithIntegerReturnObject(iterable $objects): void
    {
        $this->setClassProperty('array', $objects);

        $this->assertEquals($objects[0], $this->arrayList->get(0));
    }

    /**
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * @param string $name
     * @param $parameters
     * @return ArrayListTest
     */
    private function setClassProperty(string $name, $parameters): ArrayListTest
    {
        $reflected = new \ReflectionClass($this->arrayList);
        $property = $reflected->getProperty($name);
        $property->setAccessible(true);
        $property->setValue($this->arrayList, $parameters);

        return $this;
    }
}
