<?php

namespace FigTree\Framework\Exceptions\Handlers;

use DateTime;
use Throwable;
use Psr\Http\Message\ResponseInterface;
use FigTree\Framework\Exceptions\{
	Contracts\ExceptionResponseAdapterInterface,
	Concerns\GetsErrorLevels,
	Concerns\GetsSeverityLevels,
};

class ExceptionHandler extends AbstractExceptionHandler
{
	use GetsErrorLevels;
	use GetsSeverityLevels;

	public function __construct(protected ExceptionResponseAdapterInterface $exceptionResponseAdapter)
	{
		//
	}

	/**
	 * Handle a triggered message.
	 *
	 * @param integer $errno
	 * @param string $errstr Pipeline
	 * @return boolean
	 */
	public function handleError(int $errno, string $errstr, ?string $errfile = null, int $errline = 0): bool
	{
		$levels = static::getErrorLevels();

		$level = $this->getSeverityLevel($errno);
		$type = $levels[$errno] ?? 'UNKNOWN';

		$this->log($level, $type, $errno, $errstr, $errfile, $errline);

		return true;
	}

	/**
	 * Handle an Exception.
	 *
	 * @param \Throwable $exception
	 *
	 * @return boolean
	 */
	public function handleException(Throwable $exception): bool
	{
		$this->log($this->getLevel($exception), get_class($exception), $exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine(), $exception->getTrace());

		return true;
	}

	/**
	 * Convert an Exception to a Response.
	 *
	 * @param \Throwable $exception
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function toResponse(Throwable $exception): ResponseInterface
	{
		return $this->exceptionResponseAdapter->toResponse($exception);
	}

	/**
	 * Log a message to the Logger or system log where appropriate.
	 *
	 * @param string $level LogLevel
	 * @param string $type Exception class or PHP error level constant name.
	 * @param integer $code Exception code or PHP error level.
	 * @param string $message Message
	 * @param string|null $file File location of Exception or triggered message.
	 * @param integer $line Line location of Exception or triggered message.
	 * @param array $context Additional context. (optional)
	 *
	 * @return $this
	 */
	protected function log(string $level, string $type, int $code, string $message, ?string $file, int $line, array $context = [])
	{
		$now = new DateTime();

		if (!empty($this->logger)) {
			$info = [
				'type' => $type,
				'code' => $code,
				'file' => $file,
				'line' => $line,
			];

			if (!empty($context)) {
				$info['context'] = $context;
			}

			$this->logger->log($level, $message, $info);
		} else {
			$destination = ini_get('error_log') ?: null;

			$message = sprintf(
				'[%s] %s#%d: %s @ %s:%d',
				$level,
				$type,
				$code,
				$message,
				$file,
				$line
			);

			if (!isset($destination)) {
				error_log($message);
			} else {
				$message = sprintf('[%s] %s', $now->format(DateTime::ATOM), $message);

				error_log($message . PHP_EOL, 3, $destination);

				if (!empty($context)) {
					try {
						error_log(serialize($context), 3, $destination);
						error_log(PHP_EOL, 3, $destination);
					} catch (Throwable $exc) {
						//
					}
				}
			}
		}

		return $this;
	}
}
