<?php

namespace FigTree\Framework\Exceptions\Adapters;

use Throwable;
use Psr\Http\Message\ResponseInterface;
use FigTree\Framework\Exceptions\Contracts\ExceptionResponseAdapterInterface;
use FigTree\Framework\Exceptions\Contracts\ExceptionResponseMiddlewareInterface;

class ExceptionResponseAdapter implements ExceptionResponseAdapterInterface
{
	protected array $middleware = [];

	public function __construct(array $middleware)
	{
		foreach ($middleware as $mw) {
			if ($mw instanceof ExceptionResponseMiddlewareInterface) {
				$this->append($mw);
			}
		}
	}

	public function append(ExceptionResponseMiddlewareInterface $middleware)
	{
		array_push($this->middleware, $this->getCallable($middleware));
		return $this;
	}

	public function prepend(ExceptionResponseMiddlewareInterface $middleware)
	{
		array_unshift($this->middleware, $this->getCallable($middleware));
		return $this;
	}

	/**
	 * Run the Throwable through the Middleware and fetch the resulting Response.
	 *
	 * @param \Throwable $exception
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function toResponse(Throwable $exception): ResponseInterface
	{
		$carry = fn ($stack, $mw)
			=> fn ($exception)
			=> $mw($exception, $stack);

		$pipeline = array_reduce(array_reverse($this->middleware), $carry, $this->default());

		return $pipeline($exception);
	}

	/**
	 * The default callback to handle the value.
	 *
	 * @return mixed
	 */
	protected function default()
	{
		return function (Throwable $exception) {
			throw $exception;
		};
	}

	/**
	 * Get a callable from an ExceptionResponseMiddleware.
	 *
	 * @return callable
	 */
	protected function getCallable(ExceptionResponseMiddlewareInterface $middleware)
	{
		return [$middleware, 'process'];
	}
}
