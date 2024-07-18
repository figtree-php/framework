<?php

declare(strict_types=1);

namespace FigTree\Framework\Web\Concerns;

use Psr\Http\Message\RequestFactoryInterface;

trait RequestFactoryAware
{
	/**
	 * RequestFactory
	 *
	 * @var \Psr\Http\Message\RequestFactoryInterface
	 */
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
