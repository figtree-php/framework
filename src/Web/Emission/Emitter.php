<?php

namespace FigTree\Framework\Web\Emission;

use RuntimeException;
use Psr\Http\Message\ResponseInterface;
use FigTree\Framework\Web\Emission\Contracts\{
	EmitterInterface,
	EmitterStrategyInterface,
};

class Emitter implements EmitterInterface
{
	/**
	 * Sequential list of possible EmitterStrategies.
	 *
	 * @var array
	 */
	protected array $strategies = [];

	/**
	 * Construct an instance of Emitter.
	 *
	 * @param array $strategies
	 */
	public function __construct(array $strategies = [])
	{
		foreach ($strategies as $strategy) {
			if ($strategy instanceof EmitterStrategyInterface) {
				$this->addStrategy($strategy);
			}
		}
	}

	/**
	 * Add a possible EmitterStrategy to the bottom of the stack.
	 *
	 * @param \FigTree\Framework\Web\Emission\Contracts\EmitterStrategyInterface $strategy
	 *
	 * @return $this
	 */
	public function addStrategy(EmitterStrategyInterface $strategy)
	{
		array_push($this->strategies, $strategy);

		return $this;
	}

	/**
	 * Iterate through the stack of possible EmitterStrategies and emit using
	 * the first applicable. Throws a RuntimeException if none are applicable.
	 *
	 * @param \Psr\Http\Message\ResponseInterface $response
	 *
	 * @return int Exit status, use 0 to indicate success.
	 *
	 * @throws \RuntimeException
	 */
	public function emit(ResponseInterface $response): int
	{
		foreach ($this->strategies as $strategy) {
			if ($strategy->canEmit($response)) {
				return $strategy->emit($response);
			}
		}

		throw new RuntimeException(sprintf('No applicable EmitterStrategy set up for %s', get_class($response)));
	}
}
