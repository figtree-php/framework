<?php

declare(strict_types=1);

namespace FigTree\Framework\Exceptions\Adapters;

use Throwable;
use Psr\Http\Message\ResponseInterface;
use FigTree\Framework\Debug\Contracts\{
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
	 * @inheritDoc
	 *
	 * @param \Throwable $exception
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 *
	 * @throws \Throwable
	 */
	public function adapt(Throwable $exception): ResponseInterface
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
