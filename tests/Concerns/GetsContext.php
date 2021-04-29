<?php

namespace FigTree\Framework\Tests\Concerns;

use FigTree\Framework\Core\Context;

trait GetsContext
{
	protected function getContext(): Context
	{
		return new Context(dirname(dirname(__DIR__)));
	}
}
