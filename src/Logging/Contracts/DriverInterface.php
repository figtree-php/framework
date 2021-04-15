<?php

namespace FigTree\Framework\Logging\Contracts;

use Psr\Log\LoggerInterface;

interface DriverInterface
{
	/**
	 * Create a Logger instance.
	 *
	 * @param string $name
	 * @param array $config
	 *
	 * @return \Psr\Log\LoggerInterface
	 */
	public function createLogger(string $name, array $config): LoggerInterface;
}
