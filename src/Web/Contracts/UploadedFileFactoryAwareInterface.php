<?php

namespace FigTree\Framework\Web\Contracts;

use Psr\Http\Message\UploadedFileFactoryInterface;

interface UploadedFileFactoryAwareInterface
{
	/**
	 * Set the UploadedFileFactory instance.
	 *
	 * @param \Psr\Http\Message\UploadedFileFactoryInterface $uploadedFileFactory
	 */
	public function setUploadedFileFactory(UploadedFileFactoryInterface $uploadedFileFactory);
}
