<?php

namespace FigTree\Framework\Exceptions;

use Throwable;
use LogicException;
use FigTree\Framework\Exceptions\Contracts\SevereExceptionInterface;
use FigTree\Framework\Exceptions\Concerns\HasSeverity;

class OutputSentException extends LogicException implements SevereExceptionInterface
{
	use HasSeverity;

	protected int $severity = E_ERROR;

	public function __construct(int $code = 0, Throwable $previous = null)
	{
		$message = 'Output already sent.';

		parent::__construct($message, $code, $previous);
	}
}
