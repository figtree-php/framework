<?php

declare(strict_types=1);

namespace FigTree\Framework\Performance\Web\Middleware;

use ReflectionClass;
use ReflectionClassConstant;
use Psr\Http\Server\{
	MiddlewareInterface,
	RequestHandlerInterface,
};
use Psr\Http\Message\{
	ResponseInterface,
	ServerRequestInterface,
};
use Psr\Log\{
	LogLevel,
	LoggerAwareInterface,
	LoggerAwareTrait,
};
use FigTree\Framework\Performance\Web\Exceptions\InvalidPreloadException;

/**
 * Adds prefetch hints to the Response using the Link header to suggest resources to load to the client.
 *
 * @see https://w3c.github.io/preload/
 */
class PreloadsResources implements MiddlewareInterface, LoggerAwareInterface
{
	use LoggerAwareTrait;

	public const METHOD_PRELOAD = 'preload';
	public const METHOD_PREFETCH = 'prefetch';
	public const METHOD_PRERENDER = 'prerender';
	public const METHOD_DNS_PREFETCH = 'dns-prefetch';

	/**
	 * Stored ReflectionClass
	 */
	protected static ?ReflectionClass $mirror = null;

	/**
	 * Initialize and return the ReflectionClass instance.
	 *
	 * @return \ReflectionClass
	 */
	protected static function reflect(): ReflectionClass
	{
		if (
			self::$mirror === null ||
			self::$mirror->getName() !== static::class
		) {
			self::$mirror = new ReflectionClass(static::class);
		}

		return self::$mirror;
	}

	/**
	 * Get the list of allowed methods.
	 *
	 * @return array<string, string>
	 */
	protected static function getAllowedMethods(): array
	{
		return array_filter(
			self::reflect()->getConstants(ReflectionClassConstant::IS_PUBLIC),
			fn ($key) => (strpos($key, 'METHOD_') === 0),
			ARRAY_FILTER_USE_KEY
		);
	}

	/**
	 * Resources to add to Link header in Response.
	 */
	protected array $resources = [];

	/**
	 * Add a resource to the Link header in the Response so the client may fetch them faster.
	 *
	 * @param string $url
	 * @param string $type
	 * @param string $method
	 *
	 * @return static
	 *
	 * @throws \FigTree\Framework\Performance\Web\Exceptions\InvalidPreloadException
	 */
	public function withResource(string $url, string $type, string $method = self::METHOD_PRELOAD)
	{
		$this->validateResource($url, $type, $method);

		if ($this->isDuplicateResource($url, $type, $method)) {
			$message = sprintf(
				'Resource already added to preload list: url = "%s", type = "%s", method = "%s"',
				$url,
				$type,
				$method
			);

			$this->log(LogLevel::WARNING, $message);

			return $this;
		}

		$instance = clone $this;

		$instance->resources[] = [
			'url' => $url,
			'type' => $type,
			'method' => $method,
		];

		return $instance;
	}

	/**
	 * @inheritDoc
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Server\RequestHandlerInterface $handler
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		return $handler->handle($request)
			->withAddedHeader('Link', $this->getLinkValue());
	}

	/**
	 * Validate the given resource.
	 *
	 * @param string $url
	 * @param string $type
	 * @param string $method
	 *
	 * @return bool
	 *
	 * @throws \FigTree\Framework\Performance\Web\Exceptions\InvalidPreloadException
	 */
	protected function validateResource(string $url, string $type, string $method): bool
	{
		$valid = (
			filter_var($url, FILTER_VALIDATE_URL) !== false &&
			!empty($type) &&
			in_array($method, static::getAllowedMethods())
		);

		if (!$valid) {
			throw InvalidPreloadException::forResource($url, $type, $method);
		}

		return $valid;
	}

	/**
	 * Check if the given resource has already been added.
	 *
	 * @param string $url
	 * @param string $type
	 * @param string $method
	 *
	 * @return bool
	 */
	protected function isDuplicateResource(string $url, string $type, string $method): bool
	{
		foreach ($this->resources as $resource) {
			if (
				$resource['url'] === $url &&
				$resource['type'] === $type &&
				$resource['method'] === $method
			) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Get the serialized value of the Link header.
	 *
	 * @return string
	 */
	protected function getLinkValue(): string
	{
		$values = array_map(
			fn ($resource) => sprintf('<%1$s>; rel="%3$s"; as="%2$s"', $resource['url'], $resource['type'], $resource['method']),
			$this->resources
		);

		return implode(', ', $values);
	}

	/**
	 * Log a message to the Logger.
	 *
	 * @param string $level
	 * @param string $message
	 * @param array $context
	 *
	 * @return void
	 */
	protected function log(
		string $level = LogLevel::DEBUG,
		string $message = '',
		array $context = []
	): void {
		if (empty($this->logger)) {
			return;
		}

		$this->logger->log($level, $message, $context);
	}
}
