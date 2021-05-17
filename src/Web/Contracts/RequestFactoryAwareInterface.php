<?php

namespace FigTree\Framework\Web\Contracts;

use Psr\Http\Message\RequestFactoryInterface;

interface RequestFactoryAwareInterface
{
	/**
	 * Set the RequestFactory instance.
	 *
	 * @param \Psr\Http\Message\RequestFactoryInterface $requestFactory
	 */
	public function setRequestFactory(RequestFactoryInterface $requestFactory);
}
