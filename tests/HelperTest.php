<?php

declare(strict_types=1);

namespace FigTree\Framework\Tests;

use PHPUnit\Framework\Attributes\Test;

class HelperTest extends AbstractTestCase
{
	#[Test]
	public function testIsStringable()
	{
		$this->assertFalse(is_stringable(null));
		$this->assertFalse(is_stringable(true));
		$this->assertFalse(is_stringable(1));

		$this->assertTrue(is_stringable('true'));
	}
}
