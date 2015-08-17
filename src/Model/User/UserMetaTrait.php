<?php

namespace Fire\Model\User;

trait UserMetaTrait
{
    protected function meta($id, $key, $default = null, $format = true)
    {
        if (function_exists('get_field')) {
            $value = get_field($key, 'user_'.$id, $format);
        } else {
            $value = get_user_meta($id, $key, $format);
        }

        if (is_null($value) or $value === false or $value === '') {
            $value = $default;
        }

        return $value;
    }
}
