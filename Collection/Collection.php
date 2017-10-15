<?php

namespace Sharkzt\Collections\Collection;

/**
 * Interface Collection
 */
interface Collection
{
    /**
     * @param mixed $element
     * @param int   $index
     */
    public function add($element, int $index = null): void;

    /**
     * @param iterable $collection
     * @param int|null $index
     */
    public function addAll(iterable $collection, int $index = null): void;

    /**
     * @return void
     */
    public function clear(): void;

    /**
     * @param mixed $element
     * @return bool
     */
    public function contains($element): bool;

    /**
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * @param mixed $element
     * @return bool
     */
    public function remove($element): bool;

    /**
     * @param iterable $elements
     * @return bool
     */
    public function removeAll(iterable $elements): bool;

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return int
     */
    public function size(): int;
}
