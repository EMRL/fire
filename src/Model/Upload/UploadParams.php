<?php

namespace Fire\Model\Upload;

use Fire\Model\AbstractPost\AbstractPostParams;

class UploadParams extends AbstractPostParams {

	public function images()
	{
		return $this->add([
			'post_mime_type' => 'image',
		]);
	}

	public function videos()
	{
		return $this->add([
			'post_mime_type' => 'video',
		]);
	}

	public function texts()
	{
		return $this->add([
			'post_mime_type' => 'text',
		]);
	}

}