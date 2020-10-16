<?php declare(strict_types = 1);
/**
 * This file is part of the Everon components.
 *
 * (c) Oliwier Ptak <everonphp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Everon\Component\Collection;

use Everon\Component\Utils\Collection\ToArray;

class Collection implements CollectionInterface
{

    use ToArray;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var int
     */
    protected $position = 0;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->position = 0;
    }

    /**
     * Implement this method to feed toArray() with custom data
     *
     * @return array
     */
    protected function getArrayableData(): array
    {
        return $this->data;
    }

    public function count()
    {
        return count($this->data);
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    public function append($item): CollectionInterface
    {
        $this->offsetSet($this->count(), $item);

        return $this;
    }

    public function appendArray(array $data): CollectionInterface
    {
        $this->data += $data;

        return $this;
    }

    public function appendCollection(CollectionInterface $Collection): CollectionInterface
    {
        $this->data += $Collection->toArray();

        return $this;
    }

    public function collect(array $data): CollectionInterface
    {
        $this->data = $data;

        return $this;
    }

    public function get($name, $default = null)
    {
        if ($this->has($name) === false) {
            return $default;
        }

        return $this->offsetGet($name);
    }

    public function has($name): bool
    {
        return $this->offsetExists($name);
    }

    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    public function remove($name): CollectionInterface
    {
        $this->offsetUnset($name);

        return $this;
    }

    public function set($name, $value): CollectionInterface
    {
        $this->offsetSet($name, $value);

        return $this;
    }

    public function sortValues($ascending = true, $flags = SORT_REGULAR): CollectionInterface
    {
        if ($ascending) {
            asort($this->data, $flags);
        } else {
            arsort($this->data, $flags);
        }

        return $this;
    }

    public function sortKeys($ascending = true, $flags = SORT_REGULAR): CollectionInterface
    {
        if ($ascending) {
            ksort($this->data, $flags);
        } else {
            krsort($this->data, $flags);
        }

        return $this;
    }

    public function sortBy(\Closure $sortRoutine): CollectionInterface
    {
        uksort($this->data, $sortRoutine);

        return $this;
    }

}
