<?php

namespace FigTree\Framework\Tests\Support;

use FigTree\Framework\Support\Str;
use FigTree\Framework\Tests\AbstractTestCase;

class StrTest extends AbstractTestCase
{
	/**
	 * @small
	 */
	public function testChar()
	{
		$this->assertEquals("\t", Str::char(9));
		$this->assertEquals('å', Str::char(229));
		$this->assertEquals('€', Str::char(8364));
	}

	/**
	 * @small
	 */
	public function testCountChars()
	{
		$this->assertEquals(['f' => 1, 'o' => 2], Str::countChars('foo'));
		$this->assertEquals(['b' => 1, 'å' => 2, 'r' => 1], Str::countChars('båår'));
	}

	/**
	 * @small
	 */
	public function testExpandPath()
	{
		$this->assertEquals('/a/b/c', Str::expandPath('/a/b/d/../c'));
		$this->assertEquals('bar', Str::expandPath('foo/../bar'));
		$this->assertEquals('/bar', Str::expandPath('/foo/../bar'));
		$this->assertEquals('C:\bar', Str::expandPath('C:\foo/../bar'));
		$this->assertEquals('C:/foo/bar', Str::expandPath('C:/../foo/bar'));
		$this->assertEquals('foo/bar', Str::expandPath('foo/oof/../bar'));
		$this->assertEquals('foo/bar', Str::expandPath('foo/oof/.././bar'));
		$this->assertEquals('foo/baz', Str::expandPath('foo/oof/../bar/../baz'));
		$this->assertEquals('/test', Str::expandPath('/var/.////./user/./././..//.//../////../././.././test/////'));
	}

	/**
	 * @small
	 */
	public function testHasUniqueChars()
	{
		$this->assertFalse(Str::hasUniqueChars('foo'));
		$this->assertTrue(Str::hasUniqueChars('bar'));
		$this->assertTrue(Str::hasUniqueChars('båzo'));
	}

	/**
	 * @small
	 */
	public function testLength()
	{
		$this->assertEquals(3, Str::length('foo'));
		$this->assertEquals(4, Str::length('båzo'));
	}

	/**
	 * @small
	 */
	public function testLower()
	{
		$this->assertEquals('foo', Str::lower('FoO'));
		$this->assertEquals('båzo', Str::lower('bÅzO'));
	}

	/**
	 * @small
	 */
	public function testNormalizeEol()
	{
		$input = "a\r\nb\rc\nd\ve";

		$withCR = "a\rb\rc\rd\re";
		$withCRLF = "a\r\nb\r\nc\r\nd\r\ne";
		$withFF = "a\fb\fc\fd\fe";
		$withLF = "a\nb\nc\nd\ne";
		$withVT = "a\vb\vc\vd\ve";

		$this->assertEquals($withLF, Str::normalizeEol($input));

		$this->assertEquals($withCR, Str::normalizeEol($input, Str::CR));

		$this->assertEquals($withCRLF, Str::normalizeEol($input, Str::CRLF));

		$this->assertEquals($withFF, Str::normalizeEol($input, Str::FF));

		$this->assertEquals($withVT, Str::normalizeEol($input, Str::VTAB));
	}

	/**
	 * @small
	 */
	public function testStartsWith()
	{
		$this->assertTrue(Str::startsWith('foobar', 'foo'));
		$this->assertFalse(Str::startsWith('foobar', 'bar'));
		$this->assertTrue(Str::startsWith('dårligbåzo', 'dårlig'));
		$this->assertFalse(Str::startsWith('dårligbåzo', 'bra'));
	}

	/**
	 * @small
	 */
	public function testUpper()
	{
		$this->assertEquals('FOO', Str::upper('fOo'));
		$this->assertEquals('BÅZO', Str::upper('BåZo'));
	}
}
