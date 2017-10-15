<?php

namespace Sharkzt\Collections\Collection;

/**
 * Class ArrayList
 */
class ArrayList extends AbstractList
{
    /**
     * @param int $index
     * @return mixed
     */
    public function get(int $index)
    {
        return $this->getByIndex($index);
    }
}
