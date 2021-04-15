<?php

namespace FigTree\Framework\Exceptions;

use Throwable;
use RuntimeException;
use FigTree\Framework\Exceptions\Contracts\SevereExceptionInterface;
use FigTree\Framework\Exceptions\Concerns\HasSeverity;

class InvalidPathException extends RuntimeException implements SevereExceptionInterface
{
	use HasSeverity;

	protected int $severity = E_RECOVERABLE_ERROR;

	public function __construct(string $path, int $code = 0, Throwable $previous = null)
	{
		$message = sprintf('Path %s does not exist.', $path);

		parent::__construct($message, $code, $previous);
	}
}
