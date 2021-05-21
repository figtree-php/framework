<?php

namespace FigTree\Framework\Events;

use Psr\EventDispatcher\StoppableEventInterface;

abstract class StoppableEvent extends AbstractEvent implements StoppableEventInterface
{
	protected bool $propagationStopped = false;

	/**
	 * Is propagation stopped?
	 *
	 * This will typically only be used by the Dispatcher to determine if the
	 * previous listener halted propagation.
	 *
	 * @return bool
	 *   True if the Event is complete and no further listeners should be called.
	 *   False to continue calling listeners.
	 */
	public function isPropagationStopped(): bool
	{
		return $this->propagationStopped;
	}

	/**
	 * Stop Event propagation.
	 *
	 * @return \Psr\EventDispatcher\StoppableEventInterface
	 */
	public function stopPropagation(): StoppableEventInterface
	{
		$this->propagationStopped = true;

		return $this;
	}

	/**
	 * Resume Event propagation.
	 *
	 * @return \Psr\EventDispatcher\StoppableEventInterface
	 */
	public function resumePropagation(): StoppableEventInterface
	{
		$this->propagationStopped = false;

		return $this;
	}
}
