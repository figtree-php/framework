<?php

declare(strict_types=1);

namespace FigTree\Framework\Core\Concerns;

use FigTree\Framework\Core\Application;

trait ApplicationAware
{
	/**
	 * Application
	 *
	 * @var \FigTree\Framework\Core\Application
	 */
	protected Application $app;

	/**
	 * Set the Application instance.
	 *
	 * @param \FigTree\Framework\Core\Application $app
	 */
	public function setApp(Application $app)
	{
		$this->app = $app;
	}
}
