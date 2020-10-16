<?php declare(strict_types = 1);
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
     * @return \Everon\Component\Utils\Collection\ArrayableInterface
     */
    public function append($item): CollectionInterface;

    public function appendArray(array $data): CollectionInterface;

    public function appendCollection(CollectionInterface $Collection): CollectionInterface;

    public function collect(array $data): CollectionInterface;

    /**
     * @param string|int $name
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public function get($name, $default = null);

    /**
     * @param string|int $name
     *
     * @return bool
     */
    public function has($name): bool;

    public function isEmpty(): bool;

    public function remove(string $name): CollectionInterface;

    /**
     * @param string|int $name
     * @param mixed $value
     *
     * @return \Everon\Component\Collection\CollectionInterface
     */
    public function set($name, $value): CollectionInterface;

    public function sortValues($ascending = true, $flags = SORT_REGULAR): CollectionInterface;

    public function sortKeys($ascending = true, $flags = SORT_REGULAR): CollectionInterface;

    public function sortBy(\Closure $sortRoutine): CollectionInterface;

}
