<?php

namespace FigTree\Framework\Core\Events;

use FigTree\Framework\Core\Application;
use FigTree\Framework\Events\AbstractEvent;

class ApplicationBooted extends AbstractEvent
{
	/**
	 * Construct the ApplicationBooted Event.
	 */
	public function __construct(protected Application $app)
	{
		//
	}

	/**
	 * Get the Application.
	 *
	 * @return \FigTree\Framework\Core\Application
	 */
	public function getApplication(): Application
	{
		return $this->app;
	}
}
