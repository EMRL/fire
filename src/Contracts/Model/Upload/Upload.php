<?php

namespace Fire\Contracts\Model\Upload;

use Fire\Contracts\Model\AbstractPost\AbstractPost as AbstractPostContract;

interface Upload extends AbstractPostContract
{
    /**
     * Get the mime type of the upload
     *
     * @return string
     */
    public function mimeType();

    /**
     * Set the mime type
     *
     * @param string $mime
     */
    public function setMimeType($mime);

    /**
     * Get the URL for the upload, if upload is an image you can specify
     * the size to return.
     *
     * @param  string|null $size
     * @return string
     */
    public function fileUrl($size = 'full');

    /**
     * Get the full path for the upload, if upload is an image you can specify
     * the size to return.
     *
     * @param string|null $size
     * @return string
     */
    public function filePath($size = null);
}
