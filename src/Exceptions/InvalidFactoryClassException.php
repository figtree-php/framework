<?php

namespace FigTree\Framework\Exceptions;

use Throwable;
use LogicException;
use FigTree\Framework\Exceptions\Contracts\SevereExceptionInterface;
use FigTree\Framework\Exceptions\Concerns\HasSeverity;

class InvalidFactoryClassException extends LogicException implements SevereExceptionInterface
{
	use HasSeverity;

	protected int $severity = E_ERROR;

	public function __construct(string $factoryClass, string $expectedClass, string $inputClass, int $code = 0, Throwable $previous = null)
	{
		$message = sprintf('%s can only generate implementations of %s not %s.', $factoryClass, $expectedClass, $inputClass);

		parent::__construct($message, $code, $previous);
	}
}
