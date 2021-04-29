<?php

namespace FigTree\Framework\Support;

class Json
{
	/**
	 * Converts data to JSON but forces on the JSON_THROW_ON_ERROR flag.
	 *
	 * @param mixed $value
	 * @param integer $options
	 * @param integer $depth
	 *
	 * @return string
	 */
	public static function encode($value, int $options = 0, int $depth = 512): string
	{
		if (($options & JSON_THROW_ON_ERROR) === 0) {
			$options |= JSON_THROW_ON_ERROR;
		}

		return json_encode($value, $options, $depth);
	}

	/**
	 * Converts data from JSON but forces on the JSON_THROW_ON_ERROR flag.
	 *
	 * @param string $json
	 * @param boolean $assoc
	 * @param integer $depth
	 * @param integer $options
	 *
	 * @return string
	 */
	public static function decode(string $json, bool $assoc = false, int $depth = 512, int $options = 0)
	{
		if (($options & JSON_THROW_ON_ERROR) === 0) {
			$options |= JSON_THROW_ON_ERROR;
		}

		return json_decode($json, $assoc, $depth, $options);
	}
}
