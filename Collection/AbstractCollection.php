<?php

namespace Sharkzt\Collections\Collection;

/**
 * Class AbstractCollection
 */
abstract class AbstractCollection implements \Iterator, Collection
{
    /**
     * @var string|null
     */
    protected $class = null;

    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @var array
     */
    protected $array = [];

    /**
     * AbstractCollection constructor.
     * @param string $objectName
     */
    public function __construct(string $objectName)
    {
        $this->class = $objectName;
        $this->position = 0;
        $this->array = [];
    }

    /**
     * @param mixed $element
     * @param int   $index
     */
    public function add($element, int $index = null): void
    {
        $this->checkElementInstance($element);

        if ($index) {
            $this->checkIndex($index);
            $this->array[$index] = $element;

            return;
        }

        $this->array[] = $element;
    }

    /**
     * @param iterable $collection
     * @param int|null $index
     */
    public function addAll(iterable $collection, int $index = null): void
    {
        if ($index !== null) {
            $this->checkIndex($index);
            $collectionIndex = 0;
            for ($arrayIndex = $index; $arrayIndex < sizeof($collection); $arrayIndex++) {
                if (!isset($collection[$collectionIndex])) {
                    throw new \InvalidArgumentException(sprintf("Collection should be array contained incremented keys from zero"));
                }

                $this->checkElementInstance($collection[$collectionIndex]);
                $this->array[$arrayIndex] = $collection[$collectionIndex];
                ++$collectionIndex;
            }

            return;
        }

        foreach ($collection as $item) {
            $this->checkElementInstance($item);
            $this->array[] = $item;
        }
    }

    /**
     * @return void
     */
    public function clear(): void
    {
        $this->array = [];
    }

    /**
     * @param mixed $element
     * @return bool
     */
    public function contains($element): bool
    {
        return (bool) (in_array($element, $this->array, true));
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return (bool) (0 === (int) sizeof($this->array));
    }

    /**
     * @param mixed $element
     * @return bool
     */
    public function remove($element): bool
    {
        if ($this->contains($element)) {
            $index = array_search($element, $this->toArray(), true);
            if ($index !== false) {
                unset($this->array[$index]);

                return true;
            }
        }

        return false;
    }

    /**
     * @param iterable $elements
     * @return bool
     */
    public function removeAll(iterable $elements): bool
    {
        $initialSize = null;
        $initialSize = sizeof($this->array);

        foreach ($elements as $element) {
            $index = array_search($element, $this->toArray(), true);
            if ($index !== false) {
                unset($this->array[$index]);
            }
        }

        if (sizeof($this->array) < $initialSize && ($initialSize - sizeof($this->array)) === sizeof($elements)) {
            return true;
        }

        return false;
    }

    /**
     * @return int
     */
    public function size(): int
    {
        return sizeof($this->array);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->array;
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->array[$this->position];
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @return void
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->array[$this->position]);
    }

    /**
     * @param mixed $element
     * @return AbstractCollection
     * @throws \InvalidArgumentException
     */
    public function checkElementInstance($element): AbstractCollection
    {
        if (!($element instanceof $this->class)) {
            throw new \InvalidArgumentException(sprintf("%s should be instance of %s", $this->getClassName($element), $this->class));
        }

        return $this;
    }

    /**
     * @param int $index
     * @return AbstractCollection
     * @throws \OutOfRangeException
     */
    public function checkIndex(int $index): AbstractCollection
    {
        if (0 > $index || $this->size() < $index) {
            throw new \OutOfRangeException(sprintf("Index %s is out of range 0 - %s", $index, $this->size()));
        }

        return $this;
    }

    /**
     * @param int $index
     * @return mixed
     */
    public function getByIndex(int $index)
    {
        $this->checkIndex($index);

        return $this->array[$index] ?? null;
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
}
