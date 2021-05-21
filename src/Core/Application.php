<?php

namespace FigTree\Framework\Core;

use Throwable;
use Psr\Container\{
	ContainerInterface,
	NotFoundExceptionInterface,
};
use Psr\Http\{
	Message\ResponseInterface,
	Message\ServerRequestInterface,
	Server\RequestHandlerInterface,
};
use Psr\EventDispatcher\EventDispatcherInterface;
use FigTree\Framework\{
	Core\Events\ApplicationBooted,
	Exceptions\Contracts\ExceptionHandlerInterface,
	Web\Emission\Contracts\EmitterInterface,
};

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
	 * Get the Context instance.
	 *
	 * @return \FigTree\Framework\Core\Context
	 */
	public function getContext(): Context
	{
		return $this->context;
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
	 * Dispatch an Event.
	 *
	 * @param object $event
	 *
	 * @return object Event after modification by the Dispatcher.
	 */
	public function dispatch(object $event): object
	{
		$dispatcher = $this->getEventDispatcher();

		if (!empty($dispatcher)) {
			$event = $dispatcher->dispatch($event);
		}

		return $event;
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

		$this->dispatch(new ApplicationBooted($this));

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
	protected function getServerRequest(): ServerRequestInterface
	{
		return $this->container->get(ServerRequestInterface::class);
	}

	/**
	 * Get the ServerRequest instance.
	 *
	 * @return \Psr\Http\Server\RequestHandlerInterface
	 */
	protected function getRequestHandler(): RequestHandlerInterface
	{
		return $this->container->get(RequestHandlerInterface::class);
	}

	/**
	 * Get the Emitter instance.
	 *
	 * @return \FigTree\Framework\Web\Emission\Contracts\EmitterInterface
	 */
	protected function getEmitter(): EmitterInterface
	{
		return $this->container->get(EmitterInterface::class);
	}

	/**
	 * Get the ExceptionHandler instance.
	 *
	 * @return \FigTree\Framework\Exceptions\Contracts\ExceptionHandlerInterface|null
	 */
	protected function getExceptionHandler(): ?ExceptionHandlerInterface
	{
		try {
			return $this->container->get(ExceptionHandlerInterface::class);
		} catch (NotFoundExceptionInterface) {
			//
		}
		return null;
	}

	/**
	 * Get the EventDispatcher instance.
	 *
	 * @return \Psr\EventDispatcher\EventDispatcherInterface|null
	 */
	protected function getEventDispatcher(): ?EventDispatcherInterface
	{
		try {
			return $this->container->get(EventDispatcherInterface::class);
		} catch (NotFoundExceptionInterface) {
			//
		}
		return null;
	}
}
