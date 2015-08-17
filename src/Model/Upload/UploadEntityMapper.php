<?php

namespace Fire\Model\Upload;

use Fire\Contracts\Model\EntityMapper as EntityMapperContract;
use Fire\Contracts\Model\Entity as EntityContract;

class UploadEntityMapper implements EntityMapperContract
{
    public function map(EntityContract $entity, array $data)
    {
        $entity->setMimeType($data['post_mime_type']);
    }
}
