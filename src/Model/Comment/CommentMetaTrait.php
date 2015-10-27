<?php

namespace Fire\Model\Comment;

trait CommentMetaTrait
{
    /**
     * Get comment meta values
     *
     * @param  integer  $id
     * @param  string   $key
     * @param  mixed    $default
     * @param  boolean  $format
     * @return mixed
     */
    protected function meta($id, $key, $default = null, $format = true)
    {
        $value = get_comment_meta($id, $key, $format);

        if (is_null($value) or $value === false or $value === '') {
            $value = $default;
        }

        return $value;
    }
}
