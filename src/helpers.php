<?php

if (!function_exists('is_stringable')) {
	/**
	 * Check if the given value is a string or an object which can be cast as a string via strval.
	 *
	 * @param [type] $value
	 *
	 * @return boolean
	 */
	function is_stringable($value): bool
	{
		if (is_string($value)) {
			return true;
		}
		if (is_object($value) && $value instanceof Stringable) {
			return true;
		}
		return false;
	}
}
