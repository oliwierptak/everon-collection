<?php declare(strict_types = 1);
/**
 * This file is part of the Everon components.
 *
 * (c) Oliwier Ptak <everonphp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Everon\Component\Collection\Tests\Unit;

use Everon\Component\Collection\Collection;
use Everon\Component\Collection\CollectionInterface;
use Everon\Component\Utils\TestCase\MockeryTest;

class CollectionTest extends MockeryTest
{

    /**
     * @var array
     */
    protected $arrayFixture = [
        'foo' => 1,
        'bar' => 'barValue',
        'fuzz' => null,
    ];

    /**
     * @var CollectionInterface
     */
    protected $Collection;

    protected function setUp(): void
    {
        $this->Collection = $this->createCollectionInstance($this->arrayFixture);
    }

    /**
     * @param array $data
     *
     * @return CollectionInterface
     */
    protected function createCollectionInstance(array $data): CollectionInterface
    {
        return new Collection($data);
    }

    public function test_collection_has_Countable_interface(): void
    {
        $this->assertInstanceOf('\Countable', $this->Collection);
    }

    public function test_collection_has_ArrayAccess_interface(): void
    {
        $this->assertInstanceOf('\ArrayAccess', $this->Collection);
    }

    public function test_collection_has_IteratorAggregate_interface(): void
    {
        $this->assertInstanceOf('\IteratorAggregate', $this->Collection);
    }

    public function test_collection_has_ArrayableInterface_interface(): void
    {
        $this->assertInstanceOf('Everon\Component\Utils\Collection\ArrayableInterface', $this->Collection);
    }

    public function test_append(): void
    {
        $this->Collection->append(100);

        $expected = $this->arrayFixture;
        $expected[3] = 100;

        $this->assertEquals($expected, $this->Collection->toArray());
    }

    public function test_append_array(): void
    {
        $new_data = [
            'foobar' => 100,
        ];

        $this->Collection->appendArray($new_data);

        $expected = $this->arrayFixture + $new_data;

        $this->assertEquals($expected, $this->Collection->toArray());
    }

    public function test_append_collections(): void
    {
        $new_data = [
            'foobar' => 100,
        ];

        $this->Collection->appendCollection($this->createCollectionInstance($new_data));

        $expected = $this->arrayFixture + $new_data;

        $this->assertEquals($expected, $this->Collection->toArray());
    }

    public function test_get_with_default(): void
    {
        $this->assertEquals(25, $this->Collection->get('newkey', 25));
    }

    public function test_get_without_default(): void
    {
        $this->assertEquals(null, $this->Collection->get('newkey'));
    }

    public function test_has(): void
    {
        $this->assertEquals(false, $this->Collection->get('newkey'));
        $this->assertEquals(true, $this->Collection->get('foo'));
    }

    public function test_is_empty(): void
    {
        $this->assertEquals(false, $this->Collection->isEmpty());

        $EmptyCollection = $this->createCollectionInstance([]);
        $this->assertEquals(true, $EmptyCollection->isEmpty());
    }

    public function test_remove(): void
    {
        unset($this->arrayFixture['foo']);
        $expected = $this->arrayFixture;

        $this->Collection->remove('foo');

        $this->assertEquals($expected, $this->Collection->toArray());
    }

    public function test_set(): void
    {
        $this->Collection->set('newkey', 100);

        $expected = $this->arrayFixture;
        $expected['newkey'] = 100;

        $this->assertEquals($expected, $this->Collection->toArray());
    }

    public function test_collect(): void
    {
        $this->Collection->collect($this->arrayFixture);

        $expected = $this->arrayFixture;

        $this->assertEquals($expected, $this->Collection->toArray());
    }

    public function test_append_nested_collections_deep(): void
    {
        $data = [
            'foo' => $this->createCollectionInstance([
                'foo_nested' => 100,
                'bar_nested' => 100,
                'nested_collection' => $this->createCollectionInstance([
                    'foo_nested' => 200,
                    'bar_nested' => 200,
                ]),
            ]),
            'bar' => 'bar',
        ];

        $Collection = $this->createCollectionInstance($data);

        $expected = [
            'foo' => [
                'foo_nested' => 100,
                'bar_nested' => 100,
                'nested_collection' => [
                    'foo_nested' => 200,
                    'bar_nested' => 200,
                ],
            ],
            'bar' => 'bar',
        ];

        $this->assertEquals($expected, $Collection->toArray(true));
    }

    public function test_sort_values_ascending(): void
    {
        $Collection = $this->createCollectionInstance([
            'bar' => 3,
            'foo' => 1,
            'fuzz' => 2,
        ]);

        $Collection->sortValues();

        $expected = [
            'foo' => 1,
            'fuzz' => 2,
            'bar' => 3,
        ];

        $this->assertTrue($expected === $Collection->toArray());
    }

    public function test_sort_values_descending(): void
    {
        $Collection = $this->createCollectionInstance([
            'bar' => 3,
            'foo' => 1,
            'fuzz' => 2,
        ]);

        $Collection->sortValues(false);

        $expected = [
            'bar' => 3,
            'fuzz' => 2,
            'foo' => 1,
        ];

        $this->assertTrue($expected === $Collection->toArray());
    }

    public function test_sort_keys_ascending(): void
    {
        $this->Collection->sortKeys();

        $expected = [
            'bar' => 'barValue',
            'foo' => 1,
            'fuzz' => null,
        ];

        $this->assertTrue($expected === $this->Collection->toArray());
    }

    public function test_sort_keys_descending(): void
    {
        $this->Collection->sortKeys(false);

        $expected = [
            'fuzz' => null,
            'foo' => 1,
            'bar' => 'barValue',
        ];

        $this->assertTrue($expected === $this->Collection->toArray());
    }

    public function test_sort_by(): void
    {
        $Collection = $this->createCollectionInstance([
            'fuzz' => 2,
            'bar' => 3,
            'foo' => 1,
        ]);

        $Collection->sortBy(function ($a, $b) {
            return strcasecmp($a, $b);
        });

        $expected = [
            'bar' => 3,
            'foo' => 1,
            'fuzz' => 2,
        ];

        $this->assertTrue($expected === $Collection->toArray());
    }

    public function test_foreach(): void
    {
        foreach ($this->Collection as $key => $value) {
            $this->assertEquals($this->arrayFixture[$key], $value);
        }
    }

    public function test_for(): void
    {
        $Collection = $this->createCollectionInstance([
            'fuzz',
            'bar',
            'foo',
        ]);

        for ($x=0; $x<count($Collection); $x++) {
            $key = $Collection[$x];
            $this->assertArrayHasKey($key, $this->arrayFixture);
        }
    }

}
