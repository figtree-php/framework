<?php

namespace FigTree\Framework\Web\Exceptions\Concerns;

trait HasStatusCode
{
	/**
	 * Get the HTTP Status Code.
	 *
	 * @return integer
	 */
	public function getStatus(): int
	{
		return $this->status ?? 0;
	}

	/**
	 * Get the HTTP Status Reason.
	 *
	 * @return string
	 */
	public function getReason(): string
	{
		return $this->reason ?? '';
	}
}
