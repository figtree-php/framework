<?php

namespace FigTree\Framework\Web\Concerns;

use Psr\Http\Message\UriFactoryInterface;

trait UsesUriFactory
{
	protected UriFactoryInterface $uriFactory;

	/**
	 * Set the UriFactory instance.
	 *
	 * @param \Psr\Http\Message\UriFactoryInterface $uriFactory
	 *
	 * @return $this
	 */
	public function setUriFactory(UriFactoryInterface $uriFactory)
	{
		$this->uriFactory = $uriFactory;

		return $this;
	}
}
