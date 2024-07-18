<?php

declare(strict_types=1);

namespace FigTree\Framework\Web\Contracts;

use Psr\Http\Message\ServerRequestInterface;

interface ServerRequestAwareInterface
{
	/**
	 * Set the ServerRequest instance.
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $serverRequest
	 */
	public function setServerRequest(ServerRequestInterface $serverRequest);
}
