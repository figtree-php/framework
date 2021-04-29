<?php

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
