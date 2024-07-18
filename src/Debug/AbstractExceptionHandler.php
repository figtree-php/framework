<?php

declare(strict_types=1);

namespace FigTree\Framework\Debug;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use FigTree\Framework\Debug\Contracts\ExceptionHandlerInterface;

abstract class AbstractExceptionHandler implements
	ExceptionHandlerInterface,
	LoggerAwareInterface
{
	use LoggerAwareTrait;

	/**
	 * Installation flag.
	 *
	 * @var boolean
	 */
	protected bool $installed = false;

	/**
	 * Magic method to handle disposal.
	 */
	public function __destruct()
	{
		$this->uninstall();
	}

	/**
	 * Install the ExceptionHandler as the default PHP error and exception handler.
	 *
	 * @return boolean
	 */
	public function install(): bool
	{
		if (!$this->installed) {
			set_error_handler([$this, 'handleError']);
			set_exception_handler([$this, 'handleException']);

			$this->installed = true;

			return true;
		}

		return false;
	}

	/**
	 * Reset the previous PHP error and exception handlers.
	 *
	 * @return boolean
	 */
	public function uninstall(): bool
	{
		if ($this->installed) {
			restore_error_handler();
			restore_exception_handler();

			$this->installed = false;

			return true;
		}

		return false;
	}
}
