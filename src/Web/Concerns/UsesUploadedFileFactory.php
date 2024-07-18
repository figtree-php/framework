<?php

declare(strict_types=1);

namespace FigTree\Framework\Web\Concerns;

use Psr\Http\Message\UploadedFileFactoryInterface;

trait UsesUploadedFileFactory
{
	protected UploadedFileFactoryInterface $uploadedFileFactory;

	/**
	 * Set the UploadedFileFactory instance.
	 *
	 * @param \Psr\Http\Message\UploadedFileFactoryInterface $uploadedFileFactory
	 *
	 * @return $this
	 */
	public function setUploadedFileFactory(UploadedFileFactoryInterface $uploadedFileFactory)
	{
		$this->uploadedFileFactory = $uploadedFileFactory;

		return $this;
	}
}
