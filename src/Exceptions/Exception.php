<?php

namespace FigTree\Framework\Exceptions;

use Exception as PHPException;
use FigTree\Framework\Exceptions\Concerns\HasSeverity;
use FigTree\Framework\Exceptions\Contracts\SevereExceptionInterface;

class Exception extends PHPException implements SevereExceptionInterface
{
	use HasSeverity;

	/**
	 * Exception severity level.
	 *
	 * @var int
	 */
	protected int $severity = E_ERROR;
}
