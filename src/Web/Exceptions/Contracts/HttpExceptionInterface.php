<?php

namespace FigTree\Framework\Web\Exceptions\Contracts;

use Throwable;

interface HttpExceptionInterface extends Throwable
{
	/**
	 * Get the HTTP Status Code.
	 *
	 * @return integer
	 */
	public function getStatus(): int;

	/**
	 * Get the HTTP Status Reason.
	 *
	 * @return string
	 */
	public function getReason(): string;
}
