<?php

declare(strict_types=1);

namespace FigTree\Framework\Debug\Contracts;

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
	 * Convert a Throwable into a Response.
	 *
	 * @param \Throwable $exception
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function process(Throwable $exception): ResponseInterface;
}
