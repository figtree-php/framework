<?php

namespace FigTree\Framework\Exceptions\Contracts;

use Throwable;
use Psr\Http\Message\ResponseInterface;

interface ExceptionHandlerInterface
{
	/**
	 * Install the ExceptionHandler as the default PHP error and exception handler.
	 *
	 * @return boolean
	 */
	public function install(): bool;

	/**
	 * Reset the previous PHP error and exception handlers.
	 *
	 * @return boolean
	 */
	public function uninstall(): bool;

	/**
	 * Handle a triggered message.
	 *
	 * @param integer $errno
	 * @param string $errstr
	 * @param string|null $errfile
	 * @param integer $errline
	 *
	 * @return boolean
	 */
	public function handleError(int $errno, string $errstr, ?string $errfile = null, int $errline = 0): bool;

	/**
	 * Handle an Exception.
	 *
	 * @param \Throwable $exception
	 *
	 * @return boolean
	 */
	public function handleException(Throwable $exception): bool;

	/**
	 * Convert an Exception to a Response.
	 *
	 * @param \Throwable $exception
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function toResponse(Throwable $exception): ResponseInterface;
}
