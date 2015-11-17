<?php
/**
 * This file is part of the Everon framework.
 *
 * (c) Oliwier Ptak <oliwierptak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Everon\Component\Collection;

use Everon\Component\Collection\Helper\ArrayableInterface;

interface CollectionInterface extends ArrayableInterface
{
    /**
     * @param mixed $item
     */
    function append($item);

    /**
     * @param array $data
     *
     * @return void
     */
    public function appendArray(array $data);

    /**
     * @param CollectionInterface $Collection
     *
     * @return void
     */
    public function appendCollection(CollectionInterface $Collection);

    /**
     * @param $name
     * @param null $default
     * @return mixed|null
     */
    function get($name, $default=null);

    /**
     * @param $name
     * @return bool
     */
    function has($name);

    /**
     * @return bool
     */
    function isEmpty();

    /**
     * @param $name
     */
    function remove($name);

    /**
     * @param $name
     * @param $value
     */
    function set($name, $value);
}
