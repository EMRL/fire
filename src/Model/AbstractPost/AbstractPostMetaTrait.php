<?php

namespace Fire\Model\AbstractPost;

trait AbstractPostMetaTrait
{
    protected function meta($id, $key, $default = null, $format = true)
    {
        if (function_exists('get_field')) {
            $value = get_field($key, $id, $format);
        } else {
            $value = get_post_meta($id, $key, $format);
        }

        if (is_null($value) or $value === false or $value === '') {
            $value = $default;
        }

        return $value;
    }
}
