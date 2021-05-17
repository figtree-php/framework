<?php

namespace FigTree\Framework\Exceptions\Adapters;

use Throwable;
use Psr\Http\Message\ResponseInterface;
use FigTree\Framework\Exceptions\Contracts\{
	ExceptionResponseAdapterInterface,
	ExceptionResponseStrategyInterface
};

class ExceptionResponseAdapter implements ExceptionResponseAdapterInterface
{
	protected array $strategies = [];

	/**
	 * Construct an instance of ExceptionResponseAdapter.
	 *
	 * @param array $strategies
	 */
	public function __construct(array $strategies = [])
	{
		foreach ($strategies as $strategy) {
			if ($strategy instanceof ExceptionResponseStrategyInterface) {
				$this->addStrategy($strategy);
			}
		}
	}

	/**
	 * Add a Strategy.
	 */
	public function addStrategy(ExceptionResponseStrategyInterface $strategy)
	{
		array_push($this->strategies, $strategy);
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
		foreach ($this->strategies as $strategy) {
			if ($strategy instanceof ExceptionResponseStrategyInterface) {
				if ($strategy->matches($exception)) {
					return $strategy->process($exception);
				}
			}
		}

		throw $exception;
	}
}
