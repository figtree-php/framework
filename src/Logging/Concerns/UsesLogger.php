<?php

namespace FigTree\Framework\Logging\Concerns;

use Psr\Log\LoggerInterface;

trait UsesLogger
{
	/**
	 * Logger instance.
	 *
	 * @var \Psr\Log\LoggerInterface
	 */
	protected LoggerInterface $logger;

	/**
	 * Set the Logger instance.
	 *
	 * @param \Psr\Log\LoggerInterface|null $logger
	 *
	 * @return $this
	 */
	public function setLogger(LoggerInterface $logger)
	{
		$this->logger = $logger;

		return $this;
	}
}
