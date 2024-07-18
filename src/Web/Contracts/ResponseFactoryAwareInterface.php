<?php

declare(strict_types=1);

namespace FigTree\Framework\Web\Contracts;

use Psr\Http\Message\ResponseFactoryInterface;

interface ResponseFactoryAwareInterface
{
	/**
	 * Set the ResponseFactory instance.
	 *
	 * @param \Psr\Http\Message\ResponseFactoryInterface $responseFactory
	 */
	public function setResponseFactory(ResponseFactoryInterface $responseFactory);
}
