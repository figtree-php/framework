<?php

namespace FigTree\Framework\Web\Concerns;

use Psr\Http\Message\RequestFactoryInterface;

trait UsesRequestFactory
{
	protected RequestFactoryInterface $requestFactory;

	/**
	 * Set the RequestFactory instance.
	 *
	 * @param \Psr\Http\Message\RequestFactoryInterface $requestFactory
	 *
	 * @return $this
	 */
	public function setRequestFactory(RequestFactoryInterface $requestFactory)
	{
		$this->requestFactory = $requestFactory;

		return $this;
	}
}
