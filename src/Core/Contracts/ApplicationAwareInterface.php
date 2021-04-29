<?php

namespace FigTree\Framework\Core\Contracts;

use FigTree\Framework\Core\Application;

interface ApplicationAwareInterface
{
	/**
	 * Set the Application instance.
	 *
	 * @param \FigTree\Framework\Core\Application $app
	 */
	public function setApp(Application $app);
}
