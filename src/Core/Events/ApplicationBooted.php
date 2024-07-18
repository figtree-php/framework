<?php

declare(strict_types=1);

namespace FigTree\Framework\Core\Events;

use FigTree\Framework\Core\Application;

class ApplicationBooted
{
	/**
	 * Construct the ApplicationBooted Event.
	 *
	 * @param \FigTree\Framework\Core\Application $app
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
