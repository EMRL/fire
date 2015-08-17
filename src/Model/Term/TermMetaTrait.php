<?php

namespace Fire\Model\Term;

trait TermMetaTrait
{
    protected function meta($id, $taxonomy, $key, $default = null, $format = true)
    {
        $value = null;

        if (function_exists('get_field')) {
            $value = get_field($key, $taxonomy.'_'.$id, $format);
        }

        if (is_null($value) or $value === false or $value === '') {
            $value = $default;
        }

        return $value;
    }
}
