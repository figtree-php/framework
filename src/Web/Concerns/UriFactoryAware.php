<?php

declare(strict_types=1);

namespace FigTree\Framework\Web\Concerns;

use Psr\Http\Message\UriFactoryInterface;

trait UriFactoryAware
{
	/**
	 * UriFactory
	 *
	 * @var \Psr\Http\Message\UriFactoryInterface
	 */
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
