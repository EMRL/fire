<?php

namespace Fire\Model\Upload;

use Fire\Model\AbstractPost\AbstractPostParams;

class UploadParams extends AbstractPostParams
{
    /**
     * Set param to filter by image uploads
     *
     * @return $this
     */
    public function images()
    {
        return $this->add([
            'post_mime_type' => 'image',
        ]);
    }

    /**
     * Set param to filter by video uploads
     *
     * @return $this
     */
    public function videos()
    {
        return $this->add([
            'post_mime_type' => 'video',
        ]);
    }

    /**
     * Set param to filter by text uploads
     *
     * @return $this
     */
    public function texts()
    {
        return $this->add([
            'post_mime_type' => 'text',
        ]);
    }
}
