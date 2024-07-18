<?php

declare(strict_types=1);

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
