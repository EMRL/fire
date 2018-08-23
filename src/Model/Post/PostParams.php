<?php

namespace Fire\Model\Post;

use Fire\Model\AbstractPost\AbstractPostParams;

class PostParams extends AbstractPostParams
{
    /**
     * Set param for posts in category
     *
     * @param integer|array $id
     * @return $this
     */
    public function inCategory($id)
    {
        return $this->add([
            'category__in' => (array) $id,
        ]);
    }

    /**
     * Set param for posts with tags
     *
     * @param integer|array $id
     * @return $this
     */
    public function tagged($id)
    {
        return $this->add([
            'tag__in' => (array) $id,
        ]);
    }
}
