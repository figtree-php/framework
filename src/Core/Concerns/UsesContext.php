<?php

namespace FigTree\Framework\Core\Concerns;

use FigTree\Framework\Core\Context;

trait UsesContext
{
	/**
	 * Context instance
	 *
	 * @var \FigTree\Framework\Core\Context
	 */
	protected Context $context;

	/**
	 * Set the Context instance.
	 *
	 * @param  \FigTree\Framework\Core\Context  $context
	 *
	 * @return $this
	 */
	public function setContext(Context $context)
	{
		$this->context = $context;

		return $this;
	}
}
