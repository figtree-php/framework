<?php

namespace FigTree\Framework\Exceptions\Middleware;

use Throwable;
use Psr\Http\Message\{
	ResponseFactoryInterface,
	StreamFactoryInterface,
};

class DefaultMiddleware extends AbstractMiddleware
{
	public function __construct(protected ResponseFactoryInterface $responseFactory, protected StreamFactoryInterface $streamFactory)
	{
		//
	}

	public function process(Throwable $exception, callable $next)
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
