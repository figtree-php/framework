<?php

namespace FigTree\Framework\Tests;

class HelperTest extends AbstractTestCase
{
	/**
	 * @small
	 */
	public function testIsStringable()
	{
		$this->assertFalse(is_stringable(null));
		$this->assertFalse(is_stringable(true));
		$this->assertFalse(is_stringable(1));

		$this->assertTrue(is_stringable('true'));
	}
}
