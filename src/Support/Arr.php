<?php

namespace FigTree\Framework\Support;

class Arr
{
	/**
	 * Gets an array without the given top-level values for the given keys.
	 *
	 * @param array $array
	 * @param array $keys
	 *
	 * @return array
	 */
	public static function except(array $array, array $keys): array
	{
		return array_diff_key($array, array_flip($keys));
	}

	/**
	 * Find a key in an array by searching for a match via callback.
	 *
	 * @param array $array
	 * @param callable $callback
	 *
	 * @return mixed|null
	 */
	public static function find(array $array, callable $callback)
	{
		foreach ($array as $key => $value) {
			$matched = !!$callback($value, $key);

			if ($matched) {
				return $value;
			}
		}

		return null;
	}

	/**
	 * Get the first value in an array, or optionally the first value that
	 * passes a check by a given callback.
	 *
	 * @param array $array
	 * @param callable|null $callback
	 *
	 * @return mixed|null
	 */
	public static function first(array $array, ?callable $callback = null)
	{
		if (empty($array)) {
			return null;
		}

		if (is_null($callback)) {
			return reset($array);
		}

		foreach ($array as $key => $value) {
			$test = $callback($value, $key);

			if (!!$test) {
				return $value;
			}
		}

		return null;
	}

	/**
	 * Find a key in an array by searching for a match via callback.
	 *
	 * @param array $array
	 * @param callable $callback
	 *
	 * @return mixed|null
	 */
	public static function indexOf(array $array, callable $callback)
	{
		foreach ($array as $key => $value) {
			$matched = !!$callback($value, $key);

			if ($matched) {
				return $key;
			}
		}

		return null;
	}

	/**
	 * Get the first value in an array, or optionally the first value that
	 * passes a check by a given callback.
	 *
	 * @param array $array
	 * @param callable|null $callback
	 *
	 * @return mixed|null
	 */
	public static function last(array $array, ?callable $callback = null)
	{
		if (empty($array)) {
			return null;
		}

		$value = end($array);

		if (is_null($callback)) {
			return $value;
		}

		while ($key = key($array)) {
			$test = $callback($value, $key);

			if (!!$test) {
				return $value;
			}

			$value = prev($array);
		}

		return null;
	}

	/**
	 * Use a value if it exists in a given array. Returns the value as it exists
	 * in the array, or null if it cannot be found.
	 *
	 * @param array $array
	 * @param mixed $value
	 * @param boolean $strict
	 *
	 * @return mixed|null
	 */
	public static function oneOf(array $array, $value, bool $strict = false)
	{
		$key = array_search($value, $array, $strict);

		return ($key !== false)
			? $array[$key]
			: null;
	}

	/**
	 * Gets an array with only the given top-level values for the given keys.
	 *
	 * @param array $array
	 * @param array $keys
	 *
	 * @return array
	 */
	public static function only(array $array, array $keys): array
	{
		return array_intersect_key($array, array_flip($keys));
	}

	/**
	 * Retrieve an array value by key, removing it from the array.
	 *
	 * @param array $array
	 * @param string $key
	 *
	 * @return mixed|null
	 */
	public static function pull(array &$array, string $key)
	{
		if (key_exists($key, $array)) {
			$value = $array[$key];
			unset($array[$key]);
		}

		return $value ?? null;
	}
}
