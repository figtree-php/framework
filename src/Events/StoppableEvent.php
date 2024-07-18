<?php

declare(strict_types=1);

namespace FigTree\Framework\Events;

use Psr\EventDispatcher\StoppableEventInterface;

abstract class StoppableEvent extends AbstractEvent implements StoppableEventInterface
{
	protected bool $propagationStopped = false;

	/**
	 * @inheritDoc
	 *
	 * @return bool
	 *   True if the Event is complete and no further listeners should be called.
	 *   False to continue calling listeners.
	 */
	public function isPropagationStopped(): bool
	{
		return $this->propagationStopped;
	}
}
