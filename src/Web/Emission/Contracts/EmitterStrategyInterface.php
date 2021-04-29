<?php

namespace FigTree\Framework\Web\Emission\Contracts;

use Psr\Http\Message\ResponseInterface;

interface EmitterStrategyInterface
{
	/**
	 * Check if this is the appropriate Emitter for the Response.
	 *
	 * @param \Psr\Http\Message\ResponseInterface $response
	 *
	 * @return boolean
	 */
	public function canEmit(ResponseInterface $response): bool;

	/**
	 * Emit the Response.
	 *
	 * @param \Psr\Http\Message\ResponseInterface $response
	 *
	 * @return int Exit status, use 0 to indicate success.
	 */
	public function emit(ResponseInterface $response): int;
}
