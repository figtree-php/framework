<?php

namespace FigTree\Framework\Exceptions;

use Throwable;
use LogicException;
use FigTree\Framework\Exceptions\Contracts\SevereExceptionInterface;
use FigTree\Framework\Exceptions\Concerns\HasSeverity;

class HeadersSentException extends LogicException implements SevereExceptionInterface
{
	use HasSeverity;

	protected int $severity = E_ERROR;

	public function __construct(string $file = null, int $line = null, int $code = 0, Throwable $previous = null)
	{
		$message = (is_null($file))
			? 'Headers already sent.'
			: sprintf('Headers already sent @ %s:%d.', $file, $line ?? 0);

		parent::__construct($message, $code, $previous);
	}
}
