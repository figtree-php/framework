<?php

namespace FigTree\Framework\Exceptions\Contracts;

use Throwable;
use Psr\Http\Message\ResponseInterface;

interface ExceptionResponseStrategyInterface
{
	/**
	 * Check if this Strategy is applicable to the given Exception.
	 *
	 * @param \Throwable $exception
	 *
	 * @return boolean
	 */
	public function matches(Throwable $exception): bool;

	/**
	 * Convert an Exception into a Response.
	 *
	 * @param \Throwable $exception
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function process(Throwable $exception): ResponseInterface;
}
