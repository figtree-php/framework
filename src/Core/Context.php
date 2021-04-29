<?php

namespace FigTree\Framework\Core;

use LogicException;
use RuntimeException;
use FigTree\Framework\Support\Str;

class Context
{
	protected string $directory;

	/**
	 * Construct a Context instance.
	 *
	 * @param string $directory
	 */
	public function __construct(string $directory)
	{
		$this->setDirectory($directory);
	}

	/**
	 * Get a value from the environment.
	 *
	 * @param string $label
	 * @param mixed $default
	 * @param boolean $localOnly
	 *
	 * @return mixed
	 */
	public function env(string $label, $default = null, bool $localOnly = false)
	{
		$value = getenv($label, $localOnly);

		if ($value === false) {
			return $default;
		}

		$trValue = trim($value);
		$lcValue = strtolower(trim($value));

		if ($lcValue == 'null') {
			return null;
		}

		if (!empty($trValue)) {
			if (filter_var($trValue, FILTER_VALIDATE_INT) !== false) {
				return intval($trValue);
			}
			if (filter_var($trValue, FILTER_VALIDATE_FLOAT) !== false) {
				return floatval($trValue);
			}
			if (!is_null(filter_var($trValue, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))) {
				return boolval($trValue);
			}
		}

		return $trValue;
	}

	/**
	 * Get a path within the application context, or the base path itself.
	 *
	 * @param string|null $path
	 *
	 * @return string|null
	 */
	public function path(?string $path = null): ?string
	{
		if (is_null($path)) {
			return $this->directory;
		}

		$fullPath = Str::expandPath($this->directory . DIRECTORY_SEPARATOR . $path, DIRECTORY_SEPARATOR);

		return (str_starts_with($fullPath, $this->directory))
			? $fullPath
			: null;
	}

	/**
	 * Set the base directory for the application.
	 *
	 * @param string $directory
	 *
	 * @return $this
	 *
	 * @throws \LogicException
	 * @throws \RuntimeException
	 */
	protected function setDirectory(string $directory)
	{
		$dir = realpath($directory);

		if (empty($dir)) {
			throw new LogicException(sprintf('Directory %s does not exist.', $directory));
		}

		if (!is_dir($dir)) {
			throw new LogicException(sprintf('Path %s is not a directory', $dir));
		}

		if (!is_readable($dir)) {
			throw new RuntimeException(sprintf('Directory %s is not readable.', $dir));
		}

		$this->directory = $dir;

		return $this;
	}
}
