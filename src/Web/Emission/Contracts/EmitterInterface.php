<?php

namespace FigTree\Framework\Web\Emission\Contracts;

use Psr\Http\Message\ResponseInterface;

interface EmitterInterface
{
	/**
	 * Emit the Response.
	 *
	 * @param \Psr\Http\Message\ResponseInterface $response
	 *
	 * @return int Exit status, use 0 to indicate success.
	 */
	public function emit(ResponseInterface $response): int;
}
