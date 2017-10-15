<?php

namespace Sharkzt\Collections\Tests\Collection;

use PHPUnit\Framework\TestCase;
use Mockery as m;
use Sharkzt\Collections\Collection\AbstractCollection;

/**
 * Class AbstractCollectionTest
 */
class AbstractCollectionTest extends TestCase
{
    /**
     * @var string
     */
    private $collectionClass;

    /**
     * @var AbstractCollection
     */
    private $abstractCollection;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this
            ->setCollectionClass();

        $this->abstractCollection = $this->getMockBuilder(AbstractCollection::class)
            ->setConstructorArgs([$this->collectionClass])
            ->getMockForAbstractClass();

        $this->setClassProperty('class', $this->collectionClass);
    }

    /**
     * @return void
     */
    public function testAddWithElementReturnVoid(): void
    {
        $this->abstractCollection->add(new \stdClass());

        $this->assertInstanceOf(\stdClass::class, $this->abstractCollection->toArray()[0]);
    }

    /**
     * @return void
     */
    public function testAddWithElementAndIndexReturnVoid(): void
    {
        $this->abstractCollection->add(new \stdClass(), 0);

        $this->assertInstanceOf(\stdClass::class, $this->abstractCollection->toArray()[0]);
    }

    /**
     * @return iterable
     */
    public function elementAndIndexOutExceptionProvider(): iterable
    {
        return [
            [new \stdClass(), 1],
            [new \stdClass(), 2],
            [new \stdClass(), 99],
        ];
    }

    /**
     * @dataProvider elementAndIndexOutExceptionProvider
     *
     * @param object $object
     * @param int    $index
     * @return void
     */
    public function testAddWithElementAndWrongIndexThrowOutOfRangeException($object, int $index): void
    {
        $this->expectException(\OutOfRangeException::class);
        $this->expectExceptionMessage(sprintf("Index %s is out of range 0 - %s", $index, 0));

        $this->abstractCollection->add($object, $index);
    }

    /**
     * @return iterable
     */
    public function wrongElementAndIndexInvalidArgumentProvider(): iterable
    {
        return [
            [new \DateTime()],
            [new \Error()],
            [new \Exception('foo')],
        ];
    }

    /**
     * @dataProvider wrongElementAndIndexInvalidArgumentProvider
     *
     * @param object $object
     * @return void
     */
    public function testAddWithWrongElementAndIndexThrowsInvalidArgumentException($object): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf("%s should be instance of %s", get_class($object), $this->collectionClass));

        $this->abstractCollection->add($object);
    }

    /**
     * @return iterable
     */
    public function addAllElementsProvider(): iterable
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
     * @dataProvider addAllElementsProvider
     *
     * @param iterable $objects
     * @return void
     */
    public function testAddAllWithElementsReturnVoid(iterable $objects): void
    {
        $this->abstractCollection->addAll($objects);

        foreach ($this->abstractCollection->toArray() as $key => $object) {
            $this->assertInstanceOf(\stdClass::class, $object);
        }
    }

    /**
     * @return iterable
     */
    public function addAllWrongElementsProvider(): iterable
    {
        return [
            [
                ['foo'],
            ],
            [
                [new \DateTime(), new \DateTime()],
            ],
            [
                [new \Error(), new \stdClass(), new \Exception()],
            ],
            [
                [new \Exception(), new \stdClass(), new \Error()],
            ],
        ];
    }

    /**
     * @dataProvider addAllWrongElementsProvider
     *
     * @param iterable $objects
     * @return void
     */
    public function testAddAllWithWrongElementsThrowsInvalidArgumentException(iterable $objects): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf("%s should be instance of %s", $this->getClassName($objects[0]), $this->collectionClass));

        $this->abstractCollection->addAll($objects);
    }

    /**
     * @return iterable
     */
    public function addAllElementsAndIndexProvider(): iterable
    {
        return [
            [
                [new \stdClass()], 0, 1,
            ],
            [
                [new \stdClass(), new \stdClass()], 0, 2,
            ],
            [
                [new \stdClass(), new \stdClass(), new \stdClass()], 0, 3,
            ],
        ];
    }

    /**
     * @dataProvider addAllElementsAndIndexProvider
     *
     * @param iterable $objects
     * @param int      $index
     * @param int      $size
     * @return void
     */
    public function testAddAllWithElementsAndIndexReturnVoid(iterable $objects, int $index, int $size): void
    {
        $this->abstractCollection->addAll($objects, $index);

        foreach ($this->abstractCollection->toArray() as $key => $object) {
            $this->assertInstanceOf(\stdClass::class, $object);
        }

        $this->assertCount($size, $this->abstractCollection->toArray());
    }

    /**
     * @return iterable
     */
    public function addAllElementsAndWrongIndexProvider(): iterable
    {
        return [
            [
                [new \stdClass()], 1,
            ],
            [
                [new \stdClass(), new \stdClass()], 2,
            ],
            [
                [new \stdClass(), new \stdClass(), new \stdClass()], 99,
            ],
        ];
    }

    /**
     * @dataProvider addAllElementsAndWrongIndexProvider
     *
     * @param iterable $objects
     * @param int      $index
     * @return void
     */
    public function testAddAllWithElementsAndWrongIndexThrowsOutOfRangeException(iterable $objects, int $index): void
    {
        $this->expectException(\OutOfRangeException::class);
        $this->expectExceptionMessage(sprintf("Index %s is out of range 0 - %s", $index, 0));

        $this->abstractCollection->addAll($objects, $index);
    }

    /**
     * @return iterable
     */
    public function addAllWrongElementsAndIndexProvider(): iterable
    {
        return [
            [
                [1 => new \stdClass()], 0,
            ],
            [
                [0 => new \stdClass(), 'foo' => new \stdClass()], 0,
            ],
            [
                [0 => new \stdClass(), 1 => new \stdClass(), 99 => new \stdClass()], 0,
            ],
        ];
    }

    /**
     * @dataProvider addAllWrongElementsAndIndexProvider
     *
     * @param iterable $objects
     * @param int      $index
     * @return void
     */
    public function testAddAllWithElementsAndWrongIndexThrowsInvalidArgumentException(iterable $objects, int $index): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Collection should be array contained incremented keys from zero");

        $this->abstractCollection->addAll($objects, $index);
    }

    /**
     * @return iterable
     */
    public function objectsArrayProvider(): iterable
    {
        return [
            [
                [new \stdClass()],
            ],
            [
                [new \stdClass(), new \stdClass()],
            ],
        ];
    }

    /**
     * @dataProvider objectsArrayProvider
     *
     * @param iterable $array
     * @return void
     */
    public function testClearReturnVoid(iterable $array): void
    {
        $reflected = new \ReflectionClass($this->abstractCollection);
        $property = $reflected->getProperty('array');
        $property->setAccessible(true);
        $property->setValue($this->abstractCollection, $array);

        $this->abstractCollection->clear();

        $this->assertEquals([], $property->getValue($this->abstractCollection));
        $this->assertCount(0, $property->getValue($this->abstractCollection));
    }

    /**
     * @dataProvider objectsArrayProvider
     *
     * @param iterable $array
     * @return void
     */
    public function testContainsWithObjectReturnTrue(iterable $array): void
    {
        $reflected = new \ReflectionClass($this->abstractCollection);
        $property = $reflected->getProperty('array');
        $property->setAccessible(true);
        $property->setValue($this->abstractCollection, $array);

        $this->assertEquals(true, $this->abstractCollection->contains($array[0]));
        $this->assertTrue($this->abstractCollection->contains($array[0]));
    }

    /**
     * @dataProvider objectsArrayProvider
     *
     * @param iterable $array
     * @return void
     */
    public function testContainsWithObjectReturnFalse(iterable $array): void
    {
        $this->setClassProperty('array', $array);

        $this->assertEquals(false, $this->abstractCollection->contains('foo'));
        $this->assertFalse($this->abstractCollection->contains('foo'));
    }

    /**
     * @return void
     */
    public function testIsEmptyReturnTrue(): void
    {
        $this->setClassProperty('array', []);

        $this->assertEquals(true, $this->abstractCollection->isEmpty());
        $this->assertTrue($this->abstractCollection->isEmpty());
    }

    /**
     * @return void
     */
    public function testIsEmptyReturnFalse(): void
    {
        $this->setClassProperty('array', [new \stdClass()]);

        $this->assertEquals(false, $this->abstractCollection->isEmpty());
        $this->assertFalse($this->abstractCollection->isEmpty());
    }

    /**
     * @dataProvider objectsArrayProvider
     *
     * @param iterable $array
     * @return void
     */
    public function testRemoveWithObjectReturnTrue(iterable $array): void
    {
        $this->setClassProperty('array', $array);

        $this->assertTrue($this->abstractCollection->remove($array[0]));
    }

    /**
     * @dataProvider objectsArrayProvider
     *
     * @param iterable $array
     * @return void
     */
    public function testRemoveWithObjectReturnFalse(iterable $array): void
    {
        $this->setClassProperty('array', $array);

        $this->assertFalse($this->abstractCollection->remove(new \stdClass()));
    }

    /**
     * @dataProvider objectsArrayProvider
     *
     * @param iterable $array
     * @return void
     */
    public function testRemoveAllWithObjectsArrayReturnTrue(iterable $array): void
    {
        $this->setClassProperty('array', $array);

        $this->assertTrue($this->abstractCollection->removeAll($array));
    }

    /**
     * @dataProvider objectsArrayProvider
     *
     * @param iterable $array
     * @return void
     */
    public function testRemoveAllWithObjectsArrayReturnFalse(iterable $array): void
    {
        $this->setClassProperty('array', $array);

        $this->assertFalse($this->abstractCollection->removeAll([new \stdClass()]));
    }

    /**
     * @dataProvider objectsArrayProvider
     *
     * @param iterable $array
     * @return void
     */
    public function testSizeReturnInteger(iterable $array): void
    {
        $this->setClassProperty('array', $array);

        $this->assertEquals(sizeof($array), $this->abstractCollection->size());
    }

    /**
     * @dataProvider objectsArrayProvider
     *
     * @param iterable $array
     * @return void
     */
    public function testToArrayReturnArray(iterable $array): void
    {
        $this->setClassProperty('array', $array);

        $this->assertEquals($array, $this->abstractCollection->toArray());
    }

    /**
     * @dataProvider integersAndObjectProvider
     *
     * @param int $position
     * @return void
     */
    public function testRewindReturnInteger(int $position): void
    {
        $reflected = new \ReflectionClass($this->abstractCollection);
        $property = $reflected->getProperty('position');
        $property->setAccessible(true);
        $property->setValue($this->abstractCollection, $position);

        $this->abstractCollection->rewind();

        $this->assertEquals(0, $property->getValue($this->abstractCollection));
    }

    /**
     * @return iterable
     */
    public function integersAndObjectProvider(): iterable
    {
        return [
            [
                0, new \stdClass(),
            ],
            [
                1, new \stdClass(),
            ],
            [
                99, new \stdClass(),
            ],
        ];
    }

    /**
     * @dataProvider integersAndObjectProvider
     *
     * @param int    $position
     * @param object $object
     * @return void
     */
    public function testCurrentReturnObject(int $position, $object): void
    {
        $this
            ->setClassProperty('position', $position)
            ->setClassProperty('array', [$position => $object]);

        $this->assertEquals($object, $this->abstractCollection->current());
        $this->assertInstanceOf($this->getClassName($object), $this->abstractCollection->current());
    }

    /**
     * @dataProvider integersAndObjectProvider
     *
     * @param int $position
     * @return void
     */
    public function testKeyReturnInteger(int $position): void
    {
        $this->setClassProperty('position', $position);

        $this->assertEquals($position, $this->abstractCollection->key());
    }

    /**
     * @return void
     */
    public function testNextReturnVoid(): void
    {
        $reflected = new \ReflectionClass($this->abstractCollection);
        $property = $reflected->getProperty('position');
        $property->setAccessible(true);
        $property->setValue($this->abstractCollection, 0);

        $this->abstractCollection->next();
        $this->assertEquals(1, $property->getValue($this->abstractCollection));
        $this->abstractCollection->next();
        $this->assertEquals(2, $property->getValue($this->abstractCollection));
    }

    /**
     * @dataProvider integersAndObjectProvider
     *
     * @param int    $position
     * @param object $object
     * @return void
     */
    public function testValidReturnTrue(int $position, $object): void
    {
        if ($position !== 0) {
            $position = 0;
        }

        $this->setClassProperty('position', $position);
        $this->setClassProperty('array', [$object]);

        $this->assertTrue($this->abstractCollection->valid());
    }

    /**
     * @dataProvider integersAndObjectProvider
     *
     * @param int    $position
     * @param object $object
     * @return void
     */
    public function testValidReturnFalse(int $position, $object): void
    {
        if ($position === 0) {
            $position = 99;
        }

        $this->setClassProperty('position', $position);
        $this->setClassProperty('array', [$object]);

        $this->assertFalse($this->abstractCollection->valid());
    }

    /**
     * @dataProvider integersAndObjectProvider
     *
     * @param int    $position
     * @param object $object
     * @return void
     */
    public function testCheckElementInstanceWithObjectReturnThis(int $position, $object): void
    {
        $this
            ->setClassProperty('class', $this->getClassName($object))
            ->setClassProperty('position', $position);

        $this->assertEquals($this->abstractCollection, $this->abstractCollection->checkElementInstance($object));
    }

    /**
     * @dataProvider integersAndObjectProvider
     *
     * @param int    $position
     * @param object $object
     * @return void
     */
    public function testCheckElementInstanceWithObjectThrowsException(int $position, $object): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this
            ->setClassProperty('class', $this->getClassName(new \DateTime()))
            ->setClassProperty('position', $position);

        $this->abstractCollection->checkElementInstance($object);
    }

    /**
     * @dataProvider integersAndObjectProvider
     *
     * @param int $position
     * @return void
     */
    public function testCheckIndexWithIntegerReturnThis(int $position): void
    {
        if ($position !== 0) {
            $position = 0;
        }

        $this->setClassProperty('position', $position);

        $this->assertEquals($this->abstractCollection, $this->abstractCollection->checkIndex($position));
    }

    /**
     * @dataProvider integersAndObjectProvider
     *
     * @param int $position
     * @return void
     */
    public function testCheckIndexWithIntegerThrowsException(int $position): void
    {
        $this->expectException(\OutOfRangeException::class);

        if ($position === 0) {
            $position = 99;
        }

        $this->setClassProperty('position', $position);

        $this->abstractCollection->checkIndex($position);
    }

    /**
     * @dataProvider integersAndObjectProvider
     *
     * @param int    $position
     * @param object $object
     * @return void
     */
    public function testGetByIndexWithIntegerReturnObject(int $position, $object): void
    {
        if ($position !== 0) {
            $position = 0;
        }

        $this
            ->setClassProperty('position', $position)
            ->setClassProperty('array', [$object]);

        $this->assertEquals($object, $this->abstractCollection->getByIndex($position));
    }

    /**
     * @dataProvider integersAndObjectProvider
     *
     * @param int    $position
     * @param object $object
     * @return void
     */
    public function testGetByIndexWithIntegerThrowsException(int $position, $object): void
    {
        $this->expectException(\OutOfRangeException::class);

        if (0 === $position || 1 === $position) {
            $position = 99;
        }

        $this
            ->setClassProperty('position', $position)
            ->setClassProperty('array', [$object]);

        $this->assertEquals($object, $this->abstractCollection->getByIndex($position));
    }

    /**
     * @return void
     */
    public function tearDown(): void
    {
        m::close();
    }

    /**
     * @return AbstractCollectionTest
     */
    private function setCollectionClass(): AbstractCollectionTest
    {
        $this->collectionClass = \stdClass::class;

        return $this;
    }

    /**
     * @param $element
     * @return string
     */
    private function getClassName($element): string
    {
        if (!is_object($element)) {
            return (string) $element;
        }

        return get_class($element);
    }

    /**
     * @param string $name
     * @param $parameters
     * @return AbstractCollectionTest
     */
    private function setClassProperty(string $name, $parameters): AbstractCollectionTest
    {
        $reflected = new \ReflectionClass($this->abstractCollection);
        $property = $reflected->getProperty($name);
        $property->setAccessible(true);
        $property->setValue($this->abstractCollection, $parameters);

        return $this;
    }
}
