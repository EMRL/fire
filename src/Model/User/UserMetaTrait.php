<?php

namespace Fire\Model\User;

trait UserMetaTrait
{
    /**
     * Get user meta values
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
            $value = get_field($key, 'user_'.$id, $format);
        } else {
            $value = get_user_meta($id, $key, $format);
        }

        if (is_null($value) || $value === false || $value === '') {
            $value = $default;
        }

        return $value;
    }
}
