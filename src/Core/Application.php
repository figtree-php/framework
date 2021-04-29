<?php

namespace FigTree\Framework\Core;

use Throwable;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use FigTree\Framework\Exceptions\Contracts\ExceptionHandlerInterface;
use FigTree\Framework\Web\Emission\Contracts\EmitterInterface;

class Application
{
	/**
	 * Whether the Application has already booted.
	 *
	 * @var bool
	 */
	protected bool $booted = false;

	/**
	 * Construct an Application instance.
	 *
	 * @param \FigTree\Framework\Core\Context $context
	 * @param \Psr\Container\ContainerInterface $container
	 */
	public function __construct(protected Context $context, protected ContainerInterface $container)
	{
		//
	}

	/**
	 * Get the Container instance.
	 *
	 * @return \Psr\Container\ContainerInterface
	 */
	public function getContainer(): ContainerInterface
	{
		return $this->container;
	}

	/**
	 * Handle the HTTP Request and emit an HTTP Response.
	 *
	 * @return int
	 */
	public function serve(): int
	{
		$this->boot();

		$response = $this->getResponse();
		$emitter = $this->getEmitter();

		return $emitter->emit($response);
	}

	/**
	 * Perform routine setup.
	 *
	 * @return bool
	 */
	protected function boot(): bool
	{
		if ($this->booted) {
			return false;
		}

		$exceptionHandler = $this->getExceptionHandler();

		if (!empty($exceptionHandler)) {
			$exceptionHandler->install();
		}

		$this->booted = true;

		return true;
	}

	/**
	 * Get the Response to the ServerRequest.
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	protected function getResponse(): ResponseInterface
	{
		try {
			$request = $this->getServerRequest();
			$handler = $this->getRequestHandler();

			$response = $handler->handle($request);
		} catch (Throwable $exception) {
			$exceptionHandler = $this->getExceptionHandler();

			$exceptionHandler->handleException($exception);

			$response = $exceptionHandler->toResponse($exception);
		}

		return $response;
	}

	/**
	 * Get the ServerRequest instance.
	 *
	 * @return \Psr\Http\Message\ServerRequestInterface
	 */
	protected function getServerRequest(): ?ServerRequestInterface
	{
		return $this->container->get(ServerRequestInterface::class);
	}

	/**
	 * Get the ServerRequest instance.
	 *
	 * @return \Psr\Http\Server\RequestHandlerInterface
	 */
	protected function getRequestHandler(): ?RequestHandlerInterface
	{
		return $this->container->get(RequestHandlerInterface::class);
	}

	/**
	 * Get the Emitter instance.
	 *
	 * @return \FigTree\Framework\Web\Emission\Contracts\EmitterInterface
	 */
	protected function getEmitter(): ?EmitterInterface
	{
		return $this->container->get(EmitterInterface::class);
	}

	/**
	 * Get the ExceptionHandler instance.
	 *
	 * @return \FigTree\Framework\Exceptions\Contracts\ExceptionHandlerInterface
	 */
	protected function getExceptionHandler(): ?ExceptionHandlerInterface
	{
		return $this->container->get(ExceptionHandlerInterface::class);
	}
}
