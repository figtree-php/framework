<?php

namespace FigTree\Framework\Exceptions\Contracts;

use Throwable;

interface ExceptionResponseMiddlewareInterface
{
	public function process(Throwable $exception, callable $next);
}
