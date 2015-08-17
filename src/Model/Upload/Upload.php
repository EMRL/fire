<?php

namespace Fire\Model\Upload;

use Fire\Model\AbstractPost\AbstractPost;
use Fire\Contracts\Model\Upload\Upload as UploadContract;

class Upload extends AbstractPost implements UploadContract
{
    protected $mimeType;

    public function mimeType()
    {
        return $this->mimeType;
    }

    public function setMimeType($mime)
    {
        $this->mimeType = $mime;
    }

    public function fileUrl($size = 'full')
    {
        if ($this->isImage()) {
            list($url) = wp_get_attachment_image_src($this->id(), $size);
        } else {
            $url = wp_get_attachment_url($this->id());
        }

        return $url;
    }

    public function filePath($size = null)
    {
        if ($this->isImage() and ! is_null($size)) {
            if ($size === 'thumb') {
                $size = 'thumbnail';
            }

            $base = wp_upload_dir();
            $data = image_get_intermediate_size($this->id(), $size);

            $path = isset($data['path']) ? $base['basedir'].'/'.$data['path'] : null;
        } else {
            $path = get_attached_file($this->id(), true);
        }

        return $path;
    }

    public function isImage()
    {
        return preg_match('/^image\//i', $this->mimeType());
    }

    public function isVideo()
    {
        return preg_match('/^video\//i', $this->mimeType());
    }

    public function isText()
    {
        return preg_match('/^text\//i', $this->mimeType());
    }
}
