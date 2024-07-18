<?php

declare(strict_types=1);

namespace FigTree\Framework\Exceptions;

use Throwable;
use RuntimeException;

/**
 * Exception thrown when a path is not readable.
 */
class UnreadablePathException extends RuntimeException
{
	/**
	 * Exception thrown when a path is not readable.
	 *
	 * @param string $filename Path for which an attempt was made to read the file.
	 * @param int $code The Exception code.
	 * @param \Throwable $previous The previous throwable used for the exception chaining.
	 */
	public function __construct(string $filename, int $code = 0, Throwable $previous = null)
	{
		$message = sprintf('%s is not readable.', $filename);

		parent::__construct($message, $code, $previous);
	}
}
