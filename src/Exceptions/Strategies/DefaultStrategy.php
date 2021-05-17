<?php

namespace FigTree\Framework\Exceptions\Strategies;

use Throwable;
use Psr\Http\Message\ResponseInterface;
use FigTree\Framework\Web\Concerns\{
	UsesResponseFactory,
	UsesStreamFactory,
};
use FigTree\Framework\Web\Contracts\{
	ResponseFactoryAwareInterface,
	StreamFactoryAwareInterface,
};

class DefaultStrategy extends AbstractStrategy implements ResponseFactoryAwareInterface, StreamFactoryAwareInterface
{
	use UsesResponseFactory;
	use UsesStreamFactory;

	/**
	 * Check if this Strategy is applicable to the given Exception.
	 *
	 * @param \Throwable $exception
	 *
	 * @return boolean
	 */
	public function matches(Throwable $exception): bool
	{
		return true;
	}

	/**
	 * Convert an Exception into a Response.
	 *
	 * @param \Throwable $exception
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function process(Throwable $exception): ResponseInterface
	{
		$body = $this->formatBody($exception);

		$stream = $this->streamFactory
			->createStream($body);

		return $this->responseFactory
			->createResponse(500)
			->withBody($stream);
	}

	/**
	 * Format the body of the Response.
	 *
	 * @param \Throwable $exception
	 *
	 * @return string
	 */
	protected function formatBody(Throwable $exception): string
	{
		return sprintf(
			'%s#%d: %s @ %s:%d',
			get_class($exception),
			$exception->getCode(),
			$exception->getMessage(),
			$exception->getFile(),
			$exception->getLine(),
		);
	}
}
