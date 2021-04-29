<?php

namespace FigTree\Framework\Support;

use RuntimeException;

class Str
{
	const CR = "\r";
	const CRLF = "\r\n";
	const FF = "\f";
	const LF = "\n";
	const TAB = "\t";
	const VTAB = "\v";

	const DEFAULT_ENCODING = 'utf-8';

	/**
	 * Get the character of a given code point.
	 *
	 * @param integer $codePoint
	 * @param string $encoding
	 *
	 * @return string
	 */
	public static function char(int $codePoint, string $encoding = self::DEFAULT_ENCODING): string
	{
		$code = max(0, $codePoint);

		return mb_chr($code, $encoding);
	}

	/**
	 * Count the number of occurrences of a character in a string.
	 *
	 * @param string|null $string
	 * @param string|null $encoding
	 *
	 * @return array
	 */
	public static function countChars(?string $string, ?string $encoding = null): array
	{
		$unique = [];

		if (empty($string)) {
			return $unique;
		}

		$encoding = static::checkEncoding(__METHOD__, $string, $encoding);

		$l = static::length($string, $encoding);

		for ($i = 0; $i < $l; $i++) {
			$char = mb_substr($string, $i, 1, $encoding);

			if (!key_exists($char, $unique)) {
				$unique[$char] = 0;
			}

			$unique[$char]++;
		}

		return $unique;
	}

	/**
	 * Expand dots in a path and normalize slashes.
	 * If a separator is not provided, it will use
	 * the first directory separator encountered.
	 *
	 * @param string $path
	 * @param string|null $separator
	 *
	 * @return string
	 */
	public static function expandPath(string $path, ?string $separator = null): string
	{
		$separators = ['/', '\\'];

		if (!in_array($separator, $separators)) {
			$seps = [];

			foreach ($separators as $sep) {
				$index = strpos($path, $sep);

				if ($index !== false) {
					$seps[$sep] = $index;
				}

				unset($index);
			}

			if (!empty($seps)) {
				asort($seps);
				$separator = key($seps);
			}

			unset($seps);
		}

		$winRoot = '/^([a-z]:)$/i';

		$pattern = '/[\/]+/';

		$parts = preg_split($pattern, str_replace($separators, '/', $path));

		$expanded = [
			array_shift($parts)
		];

		$length = 1;

		while ($part = array_shift($parts)) {
			if ($part == '.') {
				continue;
			} elseif ($part == '..') {
				if ($length == 1) {
					$root = reset($expanded);

					if (empty($root) || preg_match($winRoot, $root) === 1) {
						continue;
					}
				}
				array_pop($expanded);
				$length--;
			} else {
				$expanded[] = $part;
				$length++;
			}
		}

		if ($length > 2) {
			$last = end($expanded);

			if (empty($last)) {
				array_pop($expanded);
			}
		}

		$separator ??= DIRECTORY_SEPARATOR;

		return implode($separator, $expanded);
	}

	/**
	 * Check if a string contains only a unique set of characters.
	 *
	 * @param string|null $string
	 * @param boolean $caseSensitive
	 *
	 * @return boolean
	 */
	public static function hasUniqueChars(?string $string, bool $caseSensitive = false): bool
	{
		if (empty($string)) {
			return true;
		}

		return empty(array_filter(count_chars(($caseSensitive) ? $string : strtolower($string)), fn($count) => $count > 1));
	}

	/**
	 * Get the length of a string based on its encoding.
	 *
	 * @param string|null $string
	 * @param string|null $encoding
	 *
	 * @return integer
	 */
	public static function length(?string $string, ?string $encoding = null): int
	{
		if (empty($string)) {
			return 0;
		}

		$encoding = static::checkEncoding(__METHOD__, $string, $encoding);

		return mb_strlen($string, $encoding);
	}

	/**
	 * Lowercase a string after validating its encoding.
	 *
	 * @param string|null $string
	 * @param string $encoding
	 *
	 * @return string|null
	 *
	 * @throws \RuntimeException
	 */
	public static function lower(?string $string, ?string $encoding = null): ?string
	{
		if (empty($string)) {
			return $string;
		}

		$encoding = static::checkEncoding(__METHOD__, $string, $encoding);

		return mb_strtolower($string, $encoding);
	}

	/**
	 * Convert all line endings in a string to a given line ending.
	 * Converts to line feed/newline by default.
	 *
	 * @param string $string
	 * @param string $ending
	 *
	 * @return string|null
	 */
	public static function normalizeEol(?string $string, string $ending = "\n"): ?string
	{
		if (empty($string)) {
			return $string;
		}

		$eol = Arr::oneOf([static::CR, static::CRLF, static::FF, static::VTAB], $ending)
			?: static::LF;

		$replaced = preg_replace('/\R/u', $eol, $string);

		return $replaced;
	}

	/**
	 * Check if a string starts with a fragment.
	 *
	 * @param string $subject
	 * @param string $fragment
	 * @param boolean $caseSensitive
	 * @param string|null $encoding
	 *
	 * @return boolean
	 */
	public static function startsWith(string $subject, string $fragment, bool $caseSensitive = false, ?string $encoding = null): bool
	{
		if (empty($subject)) {
			return (empty($fragment));
		}

		$subjectEncoding = static::checkEncoding(__METHOD__, $subject, $encoding);
		$fragmentEncoding = static::checkEncoding(__METHOD__, $fragment, $encoding);

		$prefix = mb_substr($subject, 0, static::length($fragment, $fragmentEncoding), $subjectEncoding);

		if (!$caseSensitive) {
			$prefix = Str::lower($prefix, $subjectEncoding);
			$fragment = Str::lower($fragment, $fragmentEncoding);
		}

		return $prefix === $fragment;
	}

	/**
	 * Title case a string after validating its encoding.
	 *
	 * @param string|null $string
	 * @param string|null $encoding
	 *
	 * @return string|null
	 *
	 * @throws \RuntimeException
	 */
	public static function title(?string $string, ?string $encoding = null): ?string
	{
		if (empty($string)) {
			return $string;
		}

		$encoding = static::checkEncoding(__METHOD__, $string, $encoding);

		return mb_convert_case($string, MB_CASE_TITLE, $encoding);
	}

	/**
	 * Trim a string after validating its encoding.
	 *
	 * @param string|null $string
	 * @param string|null $characters
	 * @param string|null $encoding
	 *
	 * @return string|null
	 *
	 * @throws \RuntimeException
	 */
	public static function trim(?string $string, ?string $characters = null, ?string $encoding = null): ?string
	{
		if (empty($string)) {
			return $string;
		}

		$encoding = static::checkEncoding(__METHOD__, $string, $encoding);

		return trim($string, $characters);
	}

	/**
	 * Uppercase a string after validating its encoding.
	 *
	 * @param string|null $string
	 * @param string|null $encoding
	 *
	 * @return string|null
	 *
	 * @throws \RuntimeException
	 */
	public static function upper(?string $string, ?string $encoding = null): ?string
	{
		if (empty($string)) {
			return $string;
		}

		$encoding = static::checkEncoding(__METHOD__, $string, $encoding);

		return mb_strtoupper($string, $encoding);
	}

	/**
	 * Verify and get the appropriate encoding of a string.
	 *
	 * @param string $method
	 * @param string|null $string
	 * @param string|null $encoding
	 *
	 * @return string
	 */
	protected static function checkEncoding(string $method, ?string $string, ?string $encoding = null): string
	{
		$encoding = mb_detect_encoding($string, $encoding, !is_null($encoding));

		if ($encoding === false) {
			throw new RuntimeException(sprintf('%s passed an improperly encoded string.', $method));
		}

		return $encoding;
	}
}
