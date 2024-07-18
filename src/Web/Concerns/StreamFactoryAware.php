<?php

declare(strict_types=1);

namespace FigTree\Framework\Web\Concerns;

use Psr\Http\Message\StreamFactoryInterface;

trait StreamFactoryAware
{
	/**
	 * StreamFactory
	 *
	 * @var \Psr\Http\Message\StreamFactoryInterface
	 */
	protected StreamFactoryInterface $streamFactory;

	/**
	 * Set the StreamFactory instance.
	 *
	 * @param \Psr\Http\Message\StreamFactoryInterface $streamFactory
	 *
	 * @return $this
	 */
	public function setStreamFactory(StreamFactoryInterface $streamFactory)
	{
		$this->streamFactory = $streamFactory;

		return $this;
	}
}
