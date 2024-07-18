<?php

declare(strict_types=1);

namespace FigTree\Framework\Web\Emission\Strategies;

use Psr\Http\Message\ResponseInterface;
use FigTree\Framework\Web\Emission\Exceptions\{
	HeadersSentException,
	OutputSentException,
};

/**
 * Default Response Emitter
 */
class DefaultEmitterStrategy extends AbstractEmitterStrategy
{
	/**
	 * Construct an instance of DefaultEmitterStrategy.
	 *
	 * @param int $emitBytes The number of bytes to emit at a time when emitting the body.
	 */
	public function __construct(protected int $emitBytes = 0)
	{
		//
	}

	/**
	 * @inheritDoc
	 *
	 * @param \Psr\Http\Message\ResponseInterface $response
	 *
	 * @return boolean
	 */
	public function matches(ResponseInterface $response): bool
	{
		return true;
	}

	/**
	 * @inheritDoc
	 *
	 * @param \Psr\Http\Message\ResponseInterface $response
	 *
	 * @return int Exit status, use 0 to indicate success.
	 */
	public function emit(ResponseInterface $response): int
	{
		$this->assertFresh();

		$this->emitStatus($response);
		$this->emitHeaders($response);
		$this->emitBody($response);

		return $this->getExitCode($response);
	}

	/**
	 * Validate that the Emitter can safely emit the Response.
	 *
	 * @return void
	 *
	 * @throws \FigTree\Exceptions\HeadersSentException
	 * @throws \FigTree\Exceptions\OutputSentException
	 */
	protected function assertFresh(): void
	{
		$file = null;
		$line = null;

		if (headers_sent($file, $line)) {
			throw new HeadersSentException();
		}

		if (ob_get_level() > 0 || ob_get_length() > 0) {
			throw new OutputSentException();
		}
	}

	/**
	 * Emit the protocol version and status.
	 *
	 * @param \Psr\Http\Message\ResponseInterface $response
	 *
	 * @return void
	 */
	protected function emitStatus(ResponseInterface $response): void
	{
		http_response_code($response->getStatusCode());
	}

	/**
	 * Emit the headers.
	 *
	 * @param \Psr\Http\Message\ResponseInterface $response
	 *
	 * @return void
	 */
	protected function emitHeaders(ResponseInterface $response): void
	{
		foreach (array_keys($response->getHeaders()) as $name) {
			$values = $response->getHeader($name);

			foreach ($values as $value) {
				header(sprintf('%s: %s', $name, $this->sanitizeHeaderValue($value)), false);
			}
		}
	}

	/**
	 * Emit the body.
	 *
	 * @param \Psr\Http\Message\ResponseInterface $response
	 *
	 * @return void
	 */
	protected function emitBody(ResponseInterface $response): void
	{
		$body = $response->getBody();

		if ($body->isSeekable()) {
			$body->rewind();
		}

		if (!$body->isReadable()) {
			echo $body;
		} else {
			if ($this->emitBytes > 0) {
				while (!$body->eof()) {
					echo $body->read($this->emitBytes);
				}
			} elseif (!$body->eof()) {
				echo $body->getContents();
			}
		}
	}

	/**
	 * Get the exit code for the Response.
	 *
	 * @param \Psr\Http\Message\ResponseInterface $response
	 *
	 * @return integer
	 */
	protected function getExitCode(ResponseInterface $response): int
	{
		$status = $response->getStatusCode();

		return ($status >= 400) ? 1 : 0;
	}

	/**
	 * Sanitize a header value to prevent header injection.
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	protected function sanitizeHeaderValue(string $value): string
	{
		return str_replace(["\r", "\n"], ['\r', '\n'], $value);
	}
}
