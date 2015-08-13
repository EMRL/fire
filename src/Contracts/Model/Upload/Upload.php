<?php

namespace Fire\Contracts\Model\Upload;

use Fire\Contracts\Model\AbstractPost\AbstractPost as AbstractPostContract;

interface Upload extends AbstractPostContract {

	public function mimeType();
	public function setMimeType($mime);

	public function fileUrl($size = 'full');

	public function filePath($size = null);
	
}