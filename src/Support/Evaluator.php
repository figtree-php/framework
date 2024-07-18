<?php

declare(strict_types=1);

namespace FigTree\Framework\Support;

use Throwable;
use FigTree\Framework\Core\Context;
use FigTree\Framework\Exceptions\{
	InvalidPathException,
	SecurityException,
	UnreadablePathException,
};

/**
 * Helper to safely include a PHP file with limited data exposure.
 */
class Evaluator
{
	/**
	 * Construct an instance of Evaluator.
	 *
	 * @param \FigTree\Framework\Core\Context $context
	 */
	public function __construct(protected Context $context)
	{
		//
	}

	/**
	 * Include a PHP file with the given data.
	 *
	 * @param string $filename The filename relative to the Application Context.
	 * @param array $data The data to expose to the included file.
	 *
	 * @return mixed
	 *
	 * @throws \FigTree\Framework\Exceptions\InvalidPathException
	 * @throws \FigTree\Framework\Exceptions\SecurityException
	 * @throws \FigTree\Framework\Exceptions\UnreadablePathException
	 */
	public function read(string $filename, array $data = []): mixed
	{
		$path = $this->context->path($filename);

		if (empty($path)) {
			throw new InvalidPathException($path);
		}

		if (!str_starts_with($path, $this->context->path())) {
			throw new SecurityException("Access to the file '{$filename}' is not allowed.");
		}

		if (!file_exists($path) || !is_readable($path)) {
			throw new UnreadablePathException($filename);
		}

		$safeData = [];

		foreach ($data as $key => $value) {
			if (is_string($key) && preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $key)) {
				$safeData[$key] = $value;
			}
		}

		$loader = new class($path) {
			public function __construct(private string $path)
			{
				//
			}

			public function __invoke(array $data = []): mixed
			{
				extract($data, EXTR_PREFIX_SAME, '_');
				return (include $this->path) ?? null;
			}
		};

		ob_start();

		try {
			$result = $loader($data);
		} catch (Throwable $exc) {
			throw new UnreadablePathException($path, 0, $exc);
		} finally {
			ob_end_clean();
		}

		return $result;
	}
}
