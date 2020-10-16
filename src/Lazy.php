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

class Lazy extends Collection
{
    /**
     * @var \Closure
     */
    protected $LazyDataLoader = null;

    public function __construct(\Closure $LazyDataLoader)
    {
        parent::__construct([]);

        $this->data = null;
        $this->LazyDataLoader = $LazyDataLoader;
    }

    protected function actuate(): void
    {
        if ($this->data === null) {
            $this->data = $this->LazyDataLoader->__invoke() ?: [];
        }
    }

    public function count()
    {
        $this->actuate();

        return parent::count();
    }

    public function offsetExists($offset)
    {
        $this->actuate();

        return parent::offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        $this->actuate();

        return parent::offsetGet($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->actuate();

        parent::offsetSet($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->actuate();

        parent::offsetUnset($offset);
    }

    public function getIterator()
    {
        $this->actuate();

        return parent::getIterator();
    }

    public function append($item): CollectionInterface
    {
        $this->actuate();

        return parent::append($item);
    }

    public function appendArray(array $data): CollectionInterface
    {
        $this->actuate();

        return parent::appendArray($data);
    }

    public function appendCollection(CollectionInterface $Collection): CollectionInterface
    {
        $this->actuate();

        return parent::appendCollection($Collection);
    }

    public function collect(array $data): CollectionInterface
    {
        $this->actuate();

        return parent::collect($data);
    }

    public function get($name, $default = null)
    {
        $this->actuate();

        return parent::get($name, $default);
    }

    public function has($name): bool
    {
        $this->actuate();

        return parent::has($name);
    }

    public function isEmpty(): bool
    {
        $this->actuate();

        return parent::isEmpty();
    }

    public function remove($name): CollectionInterface
    {
        $this->actuate();

        return parent::remove($name);
    }

    public function set($name, $value): CollectionInterface
    {
        $this->actuate();

        return parent::set($name, $value);
    }

    public function toArray($deep = false): array
    {
        $this->actuate();

        return parent::toArray($deep);
    }

    public function sortValues($ascending = true, $flags = SORT_REGULAR): CollectionInterface
    {
        $this->actuate();

        return parent::sortValues($ascending, $flags);
    }

    public function sortKeys($ascending = true, $flags = SORT_REGULAR): CollectionInterface
    {
        $this->actuate();

        return parent::sortKeys($ascending, $flags);
    }

    public function sortBy(\Closure $sortRoutine): CollectionInterface
    {
        $this->actuate();

        return parent::sortBy($sortRoutine);
    }
}
