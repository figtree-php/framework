<?php

namespace FigTree\Framework\Core\Concerns;

use FigTree\Framework\Core\Application;

trait UsesApplication
{
	/**
	 * Application instance
	 *
	 * @var \FigTree\Framework\Core\Application
	 */
	protected Application $app;

	/**
	 * Set the Application instance.
	 *
	 * @param  \FigTree\Framework\Core\Application  $app
	 *
	 * @return $this
	 */
	public function setApp(Application $app)
	{
		$this->app = $app;

		return $this;
	}
}
