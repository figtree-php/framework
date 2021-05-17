<?php

namespace FigTree\Framework\Support;

use Throwable;
use FigTree\Framework\Core\Context;
use FigTree\Exceptions\{
	InvalidPathException,
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
	 * @throws \FigTree\Exceptions\InvalidPathException
	 * @throws \FigTree\Exceptions\UnreadablePathException
	 */
	public function read(string $filename, array $data = []): mixed
	{
		$path = $this->context->path($filename);

		if (empty($path)) {
			throw new InvalidPathException($path);
		}

		ob_start();

		try {
			extract($data, EXTR_PREFIX_SAME, '_');
			$data = (include $path) ?? null;
		} catch (Throwable $exc) {
			throw new UnreadablePathException($path, 0, $exc);
		} finally {
			ob_end_clean();
		}

		return $data;
	}
}
