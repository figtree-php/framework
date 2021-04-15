<?php

namespace FigTree\Framework\Exceptions;

use Throwable;
use LogicException;
use FigTree\Framework\Exceptions\Contracts\SevereExceptionInterface;
use FigTree\Framework\Exceptions\Concerns\HasSeverity;

class InvalidClassException extends LogicException implements SevereExceptionInterface
{
	use HasSeverity;

	protected int $severity = E_ERROR;

	public function __construct(string $inputClass, int $code = 0, Throwable $previous = null)
	{
		$message = sprintf('%s is not a valid class name.', $inputClass);

		parent::__construct($message, $code, $previous);
	}
}
