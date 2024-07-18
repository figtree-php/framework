<?php

declare(strict_types=1);

namespace FigTree\Framework\Web\Concerns;

use Psr\Http\Message\ServerRequestInterface;

trait ServerRequestAware
{
	/**
	 * ServerRequest
	 *
	 * @var \Psr\Http\Message\ServerRequestInterface
	 */
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
