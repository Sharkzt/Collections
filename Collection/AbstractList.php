<?php

namespace Sharkzt\Collections\Collection;

/**
 * Class AbstractList
 */
abstract class AbstractList extends AbstractCollection
{
    /**
     * @param mixed $element
     * @return int
     */
    public function indexOf($element): int
    {
        $this->checkElementInstance($element);
        $index = array_search($element, $this->toArray(), true);

        if ($index !== false) {
            return $index;
        }

        return -1;
    }

    /**
     * @param mixed $element
     * @param int   $index
     * @return AbstractList
     */
    public function set($element, int $index): AbstractList
    {
        $this
            ->checkIndex($index)
            ->checkElementInstance($element);

        $this->toArray()[$index] = $element;

        return $this;
    }

    /**
     * @param int $index
     * @return mixed
     */
    abstract public function get(int $index);
}
