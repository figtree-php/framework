<?php

namespace FigTree\Framework\Performance\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\{
	ResponseInterface,
	ServerRequestInterface,
};

/**
 * Adds prefetch hints to the Response using the Link header to suggest resources to load to the client.
 *
 * @see https://w3c.github.io/preload/
 */
class PreloadsResources implements MiddlewareInterface
{
	/**
	 * Resources to add to Link header in Response.
	 */
	protected array $resources = [];

	/**
	 * Add an resource to the Link header in the Response so the client may fetch them faster.
	 *
	 * @param string $url
	 * @param string $type
	 * @param string $method
	 *
	 * @return $this
	 */
	public function withResource(string $url, string $type, string $method = 'preload')
	{
		$this->resources[] = [
			'url' => $url,
			'type' => $type,
			'method' => $method,
		];

		return $this;
	}

	/**
	 * Process an incoming server request.
	 *
	 * Processes an incoming server request in order to produce a response.
	 * If unable to produce the response itself, it may delegate to the provided
	 * request handler to do so.
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Server\RequestHandlerInterface $handler
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		return $handler->handle($request)
			->withAddedHeader('Link', $this->getLinkValue());
	}

	/**
	 * Get the serialized value of the Link header.
	 *
	 * @return string
	 */
	protected function getLinkValue(): string
	{
		$values = array_map(
			fn ($resource) => sprintf('<%1$s>; rel="%3$s"; as="%2$s"', $resource['url'], $resource['type'], $resource['method']),
			$this->resources
		);

		return implode(', ', $values);
	}
}
