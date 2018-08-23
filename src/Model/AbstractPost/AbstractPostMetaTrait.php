<?php

namespace Fire\Model\AbstractPost;

trait AbstractPostMetaTrait
{
    /**
     * Get post meta value
     *
     * @param integer $id
     * @param string $key
     * @param mixed $default
     * @param boolean $format
     * @return mixed
     */
    protected function meta($id, $key, $default = null, $format = true)
    {
        if (function_exists('get_field')) {
            $value = get_field($key, $id, $format);
        } else {
            $value = get_post_meta($id, $key, $format);
        }

        if (is_null($value) || $value === false || $value === '') {
            $value = $default;
        }

        return $value;
    }
}
