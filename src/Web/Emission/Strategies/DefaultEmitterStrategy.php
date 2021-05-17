<?php

namespace FigTree\Framework\Web\Emission\Strategies;

use Psr\Http\Message\ResponseInterface;
use FigTree\Exceptions\{
	HeadersSentException,
	OutputSentException,
};

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
	 * Check if this is the appropriate Emitter for the Response.
	 *
	 * @param \Psr\Http\Message\ResponseInterface $response
	 *
	 * @return boolean
	 */
	public function canEmit(ResponseInterface $response): bool
	{
		return true;
	}

	/**
	 * Emit the Response.
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
			throw (new HeadersSentException())->setLocation($file, $line);
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
		$headers = $response->getHeaders();

		$manual = [
			'host',
		];

		$multiLine = [
			'set-cookie',
		];

		foreach ($headers as $header => $values) {
			$lc = strtolower($header);

			if (!in_array($lc, $manual)) {
				if (in_array($lc, $multiLine)) {
					foreach ($values as $i => $value) {
						$line = sprintf('%s: %s', $header, strval($value));

						header($line, false);
					}
				} else {
					$line = sprintf('%s: %s', $header, $response->getHeaderLine($header));

					header($line, true);
				}
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
				$i = 0;

				while (!$body->eof() && $i < PHP_INT_MAX) {
					echo $body->read($this->emitBytes);
					$i++;
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
}
