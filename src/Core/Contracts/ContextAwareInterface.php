<?php

declare(strict_types=1);

namespace FigTree\Framework\Core\Contracts;

use FigTree\Framework\Core\Context;

interface ContextAwareInterface
{
	/**
	 * Set the Context instance.
	 *
	 * @param \FigTree\Framework\Core\Context $context
	 */
	public function setContext(Context $context);
}
