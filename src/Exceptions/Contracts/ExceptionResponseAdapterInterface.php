<?php

namespace FigTree\Framework\Exceptions\Contracts;

use Throwable;
use Psr\Http\Message\ResponseInterface;
use FigTree\Framework\Exceptions\Contracts\ExceptionResponseStrategyInterface;

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
	public function toResponse(Throwable $exception): ResponseInterface;
}
