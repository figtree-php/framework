<?php

declare(strict_types=1);

namespace FigTree\Framework\Performance\Web\Exceptions;

use Throwable;
use LogicException;

class InvalidPreloadException extends LogicException
{
	public static function forResource(
		?string $url,
		?string $type,
		?string $method,
		?int $code = 0,
		?Throwable $previous = null
	): static {
		$message = sprintf(
			'Invalid resource for preloading: url = %s, type = %s, method = %s',
			($url !== null ? "\"{$url}\"" : 'null'),
			($type !== null ? "\"{$type}\"" : 'null'),
			($method !== null ? "\"{$method}\"" : 'null')
		);

		return new static($message, $code, $previous);
	}
}
