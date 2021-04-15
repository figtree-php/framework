<?php

namespace FigTree\Framework\Exceptions\Contracts;

use Throwable;
use Psr\Http\Message\ResponseInterface;

interface ExceptionResponseAdapterInterface
{
	/**
	 * Adapt a Throwable to a Response.
	 *
	 * @param \Throwable $exception
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function toResponse(Throwable $exception): ResponseInterface;
}
