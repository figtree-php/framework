<?php

namespace FigTree\Framework\Exceptions\Concerns;

trait HasSeverity
{
	/**
	 * Get the PHP severity level associated with the Exception.
	 *
	 * @return integer
	 */
	public function getSeverity(): int
	{
		return $this->severity ?? E_ERROR;
	}
}
