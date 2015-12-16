<?php
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

    /**
     * @param \Closure $LazyDataLoader
     */
    public function __construct(\Closure $LazyDataLoader)
    {
        parent::__construct([]);
        $this->data = null;
        $this->LazyDataLoader = $LazyDataLoader;
    }

    /**
     * @return void
     */
    protected function actuate()
    {
        if ($this->data === null) {
            $this->data = $this->LazyDataLoader->__invoke() ?: [];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        $this->actuate();

        return parent::count();
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        $this->actuate();

        return parent::offsetExists($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        $this->actuate();

        return parent::offsetGet($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->actuate();
        parent::offsetSet($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $this->actuate();
        parent::offsetUnset($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        $this->actuate();

        return parent::getIterator();
    }

    /**
     * {@inheritdoc}
     */
    public function append($item): CollectionInterface
    {
        $this->actuate();

        return parent::append($item);
    }

    /**
     * {@inheritdoc}
     */
    public function appendArray(array $data): CollectionInterface
    {
        $this->actuate();

        return parent::appendArray($data);
    }

    /**
     * {@inheritdoc}
     */
    public function appendCollection(CollectionInterface $Collection): CollectionInterface
    {
        $this->actuate();

        return parent::appendCollection($Collection);
    }

    /**
     * {@inheritdoc}
     */
    public function collect(array $data): CollectionInterface
    {
        $this->actuate();

        return parent::collect($data);
    }

    /**
     * {@inheritdoc}
     */
    public function get($name, $default = null)
    {
        $this->actuate();

        return parent::get($name, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
        $this->actuate();

        return parent::has($name);
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        $this->actuate();

        return parent::isEmpty();
    }

    /**
     * {@inheritdoc}
     */
    public function remove($name): CollectionInterface
    {
        $this->actuate();

        return parent::remove($name);
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value): CollectionInterface
    {
        $this->actuate();

        return parent::set($name, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(bool $deep = false): array
    {
        $this->actuate();

        return parent::toArray($deep);
    }

    /**
     * {@inheritdoc}
     */
    public function sortValues(bool $ascending = true, int $flags = SORT_REGULAR): CollectionInterface
    {
        $this->actuate();

        return parent::sortValues($ascending, $flags);
    }

    /**
     * {@inheritdoc}
     */
    public function sortKeys(bool $ascending = true, int $flags = SORT_REGULAR): CollectionInterface
    {
        $this->actuate();

        return parent::sortKeys($ascending, $flags);
    }

    /**
     * {@inheritdoc}
     */
    public function sortBy(\Closure $sortRoutine): CollectionInterface
    {
        $this->actuate();

        return parent::sortBy($sortRoutine);
    }

}
