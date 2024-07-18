<?php

declare(strict_types=1);

namespace FigTree\Framework\Web\Concerns;

use Psr\Http\Message\ResponseFactoryInterface;

trait ResponseFactoryAware
{
	/**
	 * ResponseFactory
	 *
	 * @var \Psr\Http\Message\ResponseFactoryInterface
	 */
	protected ResponseFactoryInterface $responseFactory;

	/**
	 * Set the ResponseFactory instance.
	 *
	 * @param \Psr\Http\Message\ResponseFactoryInterface $responseFactory
	 *
	 * @return $this
	 */
	public function setResponseFactory(ResponseFactoryInterface $responseFactory)
	{
		$this->responseFactory = $responseFactory;

		return $this;
	}
}
