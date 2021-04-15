<?php

namespace FigTree\Framework\Exceptions\Concerns;

trait GetsErrorLevels
{
	/**
	 * Cached mapping of PHP error levels to their respective constant names.
	 *
	 * @var array
	 */
	protected static array $levels = [];

	/**
	 * Get the mapping of PHP error levels to their respective constant names.
	 *
	 * @param integer $level
	 *
	 * @return array
	 *
	 * @see https://www.php.net/manual/en/errorfunc.constants.php
	 */
	protected static function getErrorLevels(): array
	{
		if (empty(static::$levels)) {
			$constants = get_defined_constants(true);

			$core = $constants['Core'] ?? [];

			unset($constants);

			$filter = fn ($key) => ((strpos($key, 'E_') === 0 && $key !== 'E_ALL'));

			static::$levels = array_flip(array_filter($core, $filter, ARRAY_FILTER_USE_KEY));

			unset($core);
		}

		return static::$levels;
	}
}
