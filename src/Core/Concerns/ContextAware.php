<?php

declare(strict_types=1);

namespace FigTree\Framework\Core\Concerns;

use FigTree\Framework\Core\Context;

trait ContextAware
{
	/**
	 * Application Context
	 *
	 * @var \FigTree\Framework\Core\Context
	 */
	protected Context $context;

	/**
	 * Set the Context instance.
	 *
	 * @param \FigTree\Framework\Core\Context $context
	 */
	public function setContext(Context $context)
	{
		$this->context = $context;
	}
}
