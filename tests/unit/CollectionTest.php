<?php
/**
 * This file is part of the Everon framework.
 *
 * (c) Oliwier Ptak <EveronFramework@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Everon\Componnent\Collection\Tests;

use Everon\Component\Collection\Collection;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    protected $arrayFixture = [
        'foo' => 1,
        'bar' => 'barValue',
        'fuzz' => null
    ];

    public function test_collection_has_Countable_interface()
    {
        $Collection = new Collection($this->arrayFixture);

        $this->assertInstanceOf('\Countable', $Collection);
    }

    public function test_collection_has_ArrayAccess_interface()
    {
        $Collection = new Collection($this->arrayFixture);

        $this->assertInstanceOf('\ArrayAccess', $Collection);
    }

    public function test_collection_has_IteratorAggregate_interface()
    {
        $Collection = new Collection($this->arrayFixture);

        $this->assertInstanceOf('\IteratorAggregate', $Collection);
    }

    public function test_collection_has_ArrayableInterface_interface()
    {
        $Collection = new Collection($this->arrayFixture);

        $this->assertInstanceOf('Everon\Component\Collection\Helper\ArrayableInterface', $Collection);
    }

    public function test_append()
    {
        $Collection = new Collection($this->arrayFixture);

        $Collection->append(100);

        $expected = $this->arrayFixture;
        $expected[3] = 100;

        $this->assertEquals($expected, $Collection->toArray());
    }

    public function test_append_array()
    {
        $Collection = new Collection($this->arrayFixture);

        $new_data = [
            'foobar' => 100
        ];

        $Collection->appendArray($new_data);

        $expected = $this->arrayFixture + $new_data;

        $this->assertEquals($expected, $Collection->toArray());
    }

    public function test_append_collections()
    {
        $Collection = new Collection($this->arrayFixture);

        $new_data = [
            'foobar' => 100
        ];

        $Collection->appendCollection(new Collection($new_data));

        $expected = $this->arrayFixture + $new_data;

        $this->assertEquals($expected, $Collection->toArray());
    }

    public function test_get_with_default()
    {
        $Collection = new Collection($this->arrayFixture);

        $this->assertEquals(25, $Collection->get('newkey', 25));
    }

    public function test_get_without_default()
    {
        $Collection = new Collection($this->arrayFixture);

        $this->assertEquals(null, $Collection->get('newkey'));
    }

    public function test_has()
    {
        $Collection = new Collection($this->arrayFixture);

        $this->assertEquals(false, $Collection->get('newkey'));
        $this->assertEquals(true, $Collection->get('foo'));
    }

    public function test_is_empty()
    {
        $Collection = new Collection($this->arrayFixture);
        $this->assertEquals(false, $Collection->isEmpty());

        $EmptyCollection = new Collection([]);
        $this->assertEquals(true, $EmptyCollection->isEmpty());
    }

    public function test_remove()
    {
        $Collection = new Collection($this->arrayFixture);

        unset($this->arrayFixture['foo']);
        $expected = $this->arrayFixture;

        $Collection->remove('foo');

        $this->assertEquals($expected, $Collection->toArray());
    }

    public function test_set()
    {
        $Collection = new Collection($this->arrayFixture);

        $Collection->set('newkey', 100);

        $expected = $this->arrayFixture;
        $expected['newkey'] = 100;

        $this->assertEquals($expected, $Collection->toArray());
    }

    public function test_append_nested_collections_deep()
    {
        $data = [
            'foo' => new Collection([
                'foo_nested' => 100,
                'bar_nested' => 100,
                'nested_collection' => new Collection([
                    'foo_nested' => 200,
                    'bar_nested' => 200,
                ]),
            ]),
            'bar' => 'bar'
        ];

        $Collection = new Collection($data);

        $expected = [
            'foo' => [
                'foo_nested' => 100,
                'bar_nested' => 100,
                'nested_collection' => [
                    'foo_nested' => 200,
                    'bar_nested' => 200
                ]
            ],
            'bar' => 'bar'
        ];

        $this->assertEquals($expected, $Collection->toArray(true));
    }
}
