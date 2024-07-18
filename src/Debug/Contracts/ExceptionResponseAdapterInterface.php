<?php

declare(strict_types=1);

namespace FigTree\Framework\Debug\Contracts;

use Throwable;
use Psr\Http\Message\ResponseInterface;

interface ExceptionResponseAdapterInterface
{
	/**
	 * Add a Strategy.
	 */
	public function addStrategy(ExceptionResponseStrategyInterface $strategy);

	/**
	 * Adapt a Throwable to a Response.
	 *
	 * @param \Throwable $exception
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function adapt(Throwable $exception): ResponseInterface;
}
