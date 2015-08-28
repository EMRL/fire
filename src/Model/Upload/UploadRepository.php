<?php

namespace Fire\Model\Upload;

use Fire\Model\AbstractPost\AbstractPostRepository;
use Fire\Contracts\Model\Upload\UploadRepository as UploadRepositoryContract;

class UploadRepository extends AbstractPostRepository implements UploadRepositoryContract
{
    protected $entityClass = 'Fire\Model\Upload\Upload';

    public function uploadOfId($id)
    {
        return $this->postOfId($id);
    }

    public function uploadOfSlug($slug)
    {
        return $this->postOfSlug($slug);
    }

    /**
     * Return image uploads
     *
     * @return Fire\Foundation\Collection
     */
    public function imageUploads()
    {
        $args = $this->newParams()->images();

        return $this->find($args);
    }

    /**
     * Return video uploads
     *
     * @return Fire\Foundation\Collection
     */
    public function videoUploads()
    {
        $args = $this->newParams()->videos();

        return $this->find($args);
    }

    /**
     * Return text uploads
     *
     * @return Fire\Foundation\Collection
     */
    public function textUploads()
    {
        $args = $this->newParams()->texts();

        return $this->find($args);
    }

    protected function newParams()
    {
        return new UploadParams($this->postType);
    }
}