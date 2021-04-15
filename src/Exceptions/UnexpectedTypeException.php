<?php

namespace FigTree\Framework\Exceptions;

use Throwable;
use LogicException;
use FigTree\Framework\Exceptions\Contracts\SevereExceptionInterface;
use FigTree\Framework\Exceptions\Concerns\HasSeverity;

class UnexpectedTypeException extends LogicException implements SevereExceptionInterface
{
	use HasSeverity;

	protected int $severity = E_ERROR;

	public function __construct($value, string $expected, int $code = 0, Throwable $previous = null)
	{
		$message = sprintf(
			'Expected value of type %s; %s given.',
			$expected,
			(is_object($value) ? get_class($value) : gettype($value))
		);

		parent::__construct($message, $code, $previous);
	}
}
