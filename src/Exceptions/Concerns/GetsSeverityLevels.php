<?php

namespace FigTree\Framework\Exceptions\Concerns;

use Throwable;
use LogicException;
use ReflectionClass;
use Psr\Log\LogLevel;
use FigTree\Framework\Exceptions\Contracts\SevereExceptionInterface;

trait GetsSeverityLevels
{
	/**
	 * Map Exceptions to PHP error levels.
	 *
	 * @var array
	 */
	protected array $exceptionSeverity = [];

	/**
	 * Map PHP error levels to LogLevels.
	 *
	 * @var array
	 */
	protected array $severityLevels = [
		E_COMPILE_ERROR => LogLevel::ALERT,
		E_COMPILE_WARNING => LogLevel::WARNING,
		E_CORE_ERROR => LogLevel::ALERT,
		E_CORE_WARNING => LogLevel::WARNING,
		E_DEPRECATED => LogLevel::WARNING,
		E_ERROR => LogLevel::ERROR,
		E_NOTICE => LogLevel::NOTICE,
		E_PARSE => LogLevel::ERROR,
		E_RECOVERABLE_ERROR => LogLevel::ERROR,
		E_STRICT => LogLevel::WARNING,
		E_USER_DEPRECATED => LogLevel::WARNING,
		E_USER_ERROR => LogLevel::ERROR,
		E_USER_NOTICE => LogLevel::NOTICE,
		E_USER_WARNING => LogLevel::WARNING,
		E_WARNING => LogLevel::WARNING,
	];

	/**
	 * Get the LogLevel of an Exception.
	 *
	 * @param \Throwable $exception
	 *
	 * @return string
	 */
	public function getLevel(Throwable $exception): string
	{
		$severity = $this->getSeverity($exception);

		return $this->getSeverityLevel($severity);
	}

	/**
	 * Get the PHP error level of an Exception.
	 *
	 * @param \Throwable $exception
	 *
	 * @return integer
	 */
	public function getSeverity(Throwable $exception): int
	{
		if ($exception instanceof SevereExceptionInterface) {
			return $exception->getSeverity();
		}

		$exceptionClass = get_class($exception);

		if (key_exists($exceptionClass, $this->exceptionSeverity)) {
			return $this->exceptionSeverity[$exceptionClass];
		}

		return E_ERROR;
	}

	/**
	 * Set the PHP error level of an Exception.
	 *
	 * @param string $exceptionClass
	 * @param integer $severity
	 *
	 * @return $this
	 */
	public function setSeverity(string $exceptionClass, int $severity)
	{
		if (!is_subclass_of($exceptionClass, Throwable::class, true)) {
			throw new LogicException(sprintf('Method %s expects name of class implementing %s; %s provided.', __METHOD__, Throwable::class, $exceptionClass));
		}

		$this->exceptionSeverity[$exceptionClass] = $severity;

		return $this;
	}

	/**
	 * Get the LogLevel associated with a PHP error level.
	 *
	 * @param integer $severity
	 *
	 * @return string
	 *
	 * @see https://www.php.net/manual/en/errorfunc.constants.php
	 */
	public function getSeverityLevel(int $severity): string
	{
		return $this->severityLevels[$severity] ?? LogLevel::ERROR;
	}

	/**
	 * Override the default LogLevel of a PHP error level.
	 *
	 * @param integer $severity
	 * @param string $level
	 *
	 * @return $this
	 */
	public function setSeverityLevel(int $severity, string $level)
	{
		$logLevel = new ReflectionClass(LogLevel::class);

		$levels = $logLevel->getConstants();

		if (!in_array($level, $levels)) {
			throw new LogicException(sprintf('Method %s passed invalid LogLevel "%s".', __METHOD__, $level));
		}

		$this->severityLevels[$severity] = $level;

		return $this;
	}
}
