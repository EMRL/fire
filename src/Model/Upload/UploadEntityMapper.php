<?php

namespace Fire\Model\Upload;

use Fire\Foundation\Collection;
use Fire\Contracts\Model\EntityMapper as EntityMapperContract;
use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\Upload\UploadRepository as UploadRepositoryContract;

class UploadEntityMapper implements EntityMapperContract {

	public function map(EntityContract $entity, array $data)
	{
		$entity->setMimeType($data['post_mime_type']);
	}

}