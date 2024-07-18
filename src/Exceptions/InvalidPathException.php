<?php

declare(strict_types=1);

namespace FigTree\Framework\Exceptions;

use Throwable;
use RuntimeException;

/**
 * Exception thrown when a path does not exist.
 */
class InvalidPathException extends RuntimeException
{
	/**
	 * Exception thrown when a path does not exist.
	 *
	 * @param string $path The path being checked for existence.
	 * @param int $code The Exception code.
	 * @param \Throwable $previous The previous throwable used for the exception chaining.
	 */
	public function __construct(string $path, int $code = 0, Throwable $previous = null)
	{
		$message = sprintf('Path %s does not exist.', $path);

		parent::__construct($message, $code, $previous);
	}
}
