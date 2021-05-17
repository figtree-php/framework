<?php

namespace FigTree\Framework\Web\Contracts;

use Psr\Http\Message\UriFactoryInterface;

interface UriFactoryAwareInterface
{
	/**
	 * Set the UriFactory instance.
	 *
	 * @param \Psr\Http\Message\UriFactoryInterface $uriFactory
	 */
	public function setUriFactory(UriFactoryInterface $uriFactory);
}
