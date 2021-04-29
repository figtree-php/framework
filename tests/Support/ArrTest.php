<?php

namespace FigTree\Framework\Tests\Support;

use FigTree\Framework\Support\Arr;
use FigTree\Framework\Tests\AbstractTestCase;

class ArrTest extends AbstractTestCase
{
	/**
	 * @small
	 */
	public function testExcept()
	{
		$array = [
			'a' => 1,
			'b' => 2,
			'c' => 3,
		];

		$this->assertSame($array, Arr::except($array, []));

		$this->assertSame($array, Arr::except($array, ['d']));

		$this->assertSame(['b' => 2], Arr::except($array, ['a', 'c']));

		$this->assertSame(['a' => 1, 'c' => 3], Arr::except($array, ['b']));
	}

	/**
	 * @small
	 */
	public function testFind()
	{
		$array = [
			'a' => 1,
			'b' => 2,
			'c' => 3,
		];

		$this->assertEquals(
			2,
			Arr::find($array, fn ($value, $key) => ($key == 'b' && $value == 2))
		);
	}

	/**
	 * @small
	 */
	public function testFirst()
	{
		$array = ['a', 'b', 'c'];

		$this->assertNull(Arr::first([]));

		$this->assertEquals('a', Arr::first($array));

		$this->assertNotEquals('c', Arr::first($array));

		$this->assertEquals('b', Arr::first($array, function ($value, $key) {
			return $key > 0;
		}));

		$this->assertNull(Arr::first($array, function ($value, $key) {
			return $key > 2;
		}));
	}

	/**
	 * @small
	 */
	public function testIndexOf()
	{
		$array = [
			'a' => 1,
			'b' => 2,
			'c' => 3,
		];

		$this->assertEquals(
			'b',
			Arr::indexOf($array, fn ($value, $key) => ($key == 'b' && $value == 2))
		);
	}

	/**
	 * @small
	 */
	public function testLast()
	{
		$array = ['a', 'b', 'c'];

		$this->assertNull(Arr::last([]));

		$this->assertEquals('c', Arr::last($array));

		$this->assertNotEquals('a', Arr::last($array));

		$this->assertEquals('c', Arr::last($array, function ($value, $key) {
			return $key > 0;
		}));

		$this->assertNull(Arr::last($array, function ($value, $key) {
			return $key > 2;
		}));
	}

	/**
	 * @small
	 */
	public function testOneOf()
	{
		$array = [1, 3, 5];

		$this->assertNull(Arr::oneOf([], 1));

		$this->assertNull(Arr::oneOf($array, 7));

		$this->assertEquals(5, Arr::oneOf($array, 5));

		$this->assertEquals(3, Arr::oneOf($array, '3'));

		$this->assertEquals(1, Arr::oneOf($array, 1, true));

		$this->assertNull(Arr::oneOf($array, '3', true));
	}

	/**
	 * @small
	 */
	public function testOnly()
	{
		$array = [
			'a' => 1,
			'b' => 2,
			'c' => 3,
		];

		$this->assertEmpty(Arr::only($array, []));

		$this->assertSame($array, Arr::only($array, ['a', 'b', 'c']));

		$this->assertSame(['b' => 2], Arr::only($array, ['b']));

		$this->assertSame(['a' => 1, 'c' => 3], Arr::only($array, ['a', 'c']));
	}

	/**
	 * @small
	 */
	public function testPull()
	{
		$array = [
			'a' => 1,
			'b' => 2,
			'c' => 3,
		];

		$pulled = Arr::pull($array, 'b');

		$this->assertEquals(2, $pulled);

		$this->assertSame(['a' => 1, 'c' => 3], $array);
	}
}
