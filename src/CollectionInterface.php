<?php
/**
 * This file is part of the Everon components.
 *
 * (c) Oliwier Ptak <oliwierptak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Everon\Component\Collection;

use Everon\Component\Utils\Collection\ArrayableInterface;

interface CollectionInterface extends ArrayableInterface, \Countable, \ArrayAccess, \IteratorAggregate
{

    /**
     * @param mixed $item
     *
     * @return self
     */
    public function append($item): CollectionInterface;

    /**
     * @param array $data
     *
     * @return self
     */
    public function appendArray(array $data): CollectionInterface;

    /**
     * @param CollectionInterface $Collection
     *
     * @return self
     */
    public function appendCollection(CollectionInterface $Collection): CollectionInterface;

    /**
     * @param array $data
     *
     * @return self
     */
    public function collect(array $data): CollectionInterface;

    /**
     * @param mixed $name
     * @param mixed $default null
     *
     * @return mixed
     */
    public function get($name, $default = null);

    /**
     * @param $name
     *
     * @return bool
     */
    public function has($name);

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @param $name
     *
     * @return self
     */
    public function remove($name): CollectionInterface;

    /**
     * @param $name
     * @param $value
     *
     * @return self
     */
    public function set($name, $value): CollectionInterface;

    /**
     * @param bool $ascending true
     * @param int $flags SORT_REGULAR
     *
     * @return self
     */
    public function sortValues(bool $ascending = true, int $flags = SORT_REGULAR): CollectionInterface;

    /**
     * @param bool $ascending true
     * @param int $flags SORT_REGULAR
     *
     * @return self
     */
    public function sortKeys(bool $ascending = true, int $flags = SORT_REGULAR): CollectionInterface;

    /**
     * @param \Closure $sortRoutine
     *
     * @return self
     */
    public function sortBy(\Closure $sortRoutine): CollectionInterface;

}
