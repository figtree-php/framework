<?php

namespace FigTree\Framework\Tests;

use LogicException;

class MetaTest extends AbstractTestCase
{
	/**
	 * @small
	 */
	public function testData()
	{
		$this->assertNotNull($this->dataDir);

		$text = $this->data('txt/dummy.txt');

		$this->assertEquals('this is a text file', $text);
	}

	/**
	 * @small
	 */
	public function testDataDoesNotExist()
	{
		$this->expectException(LogicException::class);
		$this->expectExceptionMessage("Could not resolve path 'txt/does-not-exist.txt'");

		$this->data('txt/does-not-exist.txt');
	}

	/**
	 * @small
	 */
	public function testDataOutsideData()
	{
		$this->expectException(LogicException::class);
		$this->expectExceptionMessage("Path '../../phpunit.xml' resides outside of Data directory");

		$this->data('../../phpunit.xml');
	}

	/**
	 * @small
	 */
	public function testDataIsNotFile()
	{
		$this->expectException(LogicException::class);
		$this->expectExceptionMessage("Path 'txt' is not a file");

		$this->data('txt');
	}
}
