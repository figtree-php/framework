<?php

namespace FigTree\Framework\Exceptions;

use Throwable;
use RuntimeException;
use FigTree\Framework\Exceptions\Contracts\SevereExceptionInterface;
use FigTree\Framework\Exceptions\Concerns\HasSeverity;

class UnreadablePathException extends RuntimeException implements SevereExceptionInterface
{
	use HasSeverity;

	protected int $severity = E_RECOVERABLE_ERROR;

	public function __construct(string $filename, int $code = 0, Throwable $previous = null)
	{
		$message = sprintf('%s is not readable.', $filename);

		parent::__construct($message, $code, $previous);
	}
}
