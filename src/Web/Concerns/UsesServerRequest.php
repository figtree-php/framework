<?php

namespace FigTree\Framework\Web\Concerns;

use Psr\Http\Message\ServerRequestInterface;

trait UsesServerRequest
{
	protected ServerRequestInterface $serverRequest;

	/**
	 * Set the ServerRequest instance.
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $serverRequest
	 *
	 * @return $this
	 */
	public function setServerRequest(ServerRequestInterface $serverRequest)
	{
		$this->serverRequest = $serverRequest;

		return $this;
	}
}
