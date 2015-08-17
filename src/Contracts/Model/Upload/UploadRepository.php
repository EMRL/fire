<?php

namespace Fire\Contracts\Model\Upload;

interface UploadRepository
{
    public function uploadOfId($id);

    public function uploadOfSlug($slug);

    public function find($args = null);
}
