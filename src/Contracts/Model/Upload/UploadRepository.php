<?php

namespace Fire\Contracts\Model\Upload;

interface UploadRepository
{
    /**
     * Return an upload of the specified ID
     *
     * @param integer $id
     * @return Fire\Contracts\Upload\Upload
     */
    public function uploadOfId($id);

    /**
     * Return an upload of the specified slug
     *
     * @param string $slug
     * @return Fire\Contracts\Upload\Upload
     */
    public function uploadOfSlug($slug);

    /**
     * Return a collection of uploads
     *
     * @param Fire\Contracts\Foundation\Arrayable|array|null $args
     * @return Fire\Foundation\Collection
     */
    public function find($args = null);
}
