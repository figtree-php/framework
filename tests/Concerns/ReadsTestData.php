<?php

namespace FigTree\Framework\Tests\Concerns;

use LogicException;

trait ReadsTestData
{
	protected string $dataDir;

	/**
	 * Set the location of the Data directory.
	 *
	 * @param string $dataDir
	 *
	 * @return void
	 *
	 * @throws \LogicException
	 */
	protected function setDataDir(string $dataDir)
	{
		$path = realpath($dataDir);

		if (empty($path) || !is_dir($path)) {
			throw new LogicException("Invalid data directory '${dataDir}'");
		}

		$this->dataDir = $path;
	}

	/**
	 * Get the location of the Data directory.
	 *
	 * @return string
	 */
	protected function getDataDir(): string
	{
		return $this->dataDir;
	}

	/**
	 * Get the contents of a test file in the Data directory.
	 *
	 * @param string $path
	 *
	 * @return string|null
	 *
	 * @throws \LogicException
	 */
	public function data(string $path)
	{
		$trimmed = str_replace('/', DIRECTORY_SEPARATOR, trim($path, '\\/'));

		$realpath = realpath($this->getDataDir() . DIRECTORY_SEPARATOR . $trimmed) ?: null;

		if (empty($realpath)) {
			throw new LogicException("Could not resolve path '${path}'");
		}

		if (!str_starts_with($realpath, $this->getDataDir())) {
			throw new LogicException("Path '${path}' resides outside of Data directory");
		}

		if (!is_file($realpath) || is_dir($realpath)) {
			throw new LogicException("Path '${path}' is not a file");
		}

		if (!is_readable($realpath)) {
			throw new LogicException("Path '${path}' is not readable");
		}

		return file_get_contents($realpath) ?: null;
	}
}
