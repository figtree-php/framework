<?php

namespace FigTree\Framework\Web\Contracts;

use Psr\Http\Message\StreamFactoryInterface;

interface StreamFactoryAwareInterface
{
	/**
	 * Set the StreamFactory instance.
	 *
	 * @param \Psr\Http\Message\StreamFactoryInterface $streamFactory
	 */
	public function setStreamFactory(StreamFactoryInterface $streamFactory);
}
