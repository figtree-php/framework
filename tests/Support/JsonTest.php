<?php

namespace FigTree\Framework\Tests\Support;

use JsonException;
use FigTree\Framework\Support\Json;
use FigTree\Framework\Tests\AbstractTestCase;

class JsonTest extends AbstractTestCase
{
	/**
	 * @small
	 */
	public function testEncode()
	{
		$array = ['a' => 1, 'b' => 2, 'c' => 3];

		$valid = '{"a":1,"b":2,"c":3}';

		$invalid = [ NAN ];

		$this->assertSame($valid, Json::encode($array));

		$this->expectException(JsonException::class);

		$encoded = Json::encode($invalid);
	}

	/**
	 * @small
	 */
	public function testDecode()
	{
		$array = ['a' => 1, 'b' => 2, 'c' => 3];

		$valid = '{"a":1,"b":2,"c":3}';

		$invalid = substr($valid, 0, 3);

		$this->assertSame($array, Json::decode($valid, true));

		$this->expectException(JsonException::class);

		$decoded = Json::decode($invalid, true);
	}
}
