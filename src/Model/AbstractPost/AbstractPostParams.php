<?php

namespace Fire\Model\AbstractPost;

use Fire\Foundation\Params;

class AbstractPostParams extends Params
{
    /**
     * @var string
     */
    protected $postType;

    /**
     * @param string $postType
     */
    public function __construct($postType)
    {
        $this->postType = $postType;
    }

    /**
     * Set param for author
     *
     * @param integer $id
     * @return $this
     */
    public function byAuthor($id)
    {
        return $this->add([
            'author__in' => (array) $id,
        ]);
    }

    protected function defaultParams()
    {
        return [
            'post_type' => $this->postType,
            'posts_per_page' => -1,
            'suppress_filters' => false,
        ];
    }
}
