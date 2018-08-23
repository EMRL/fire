<?php

namespace Fire\Model\Term;

trait TermMetaTrait
{
    /**
     * Get term meta values
     *
     * @param integer $id
     * @param string $taxonomy
     * @param string $key
     * @param mixed $default
     * @param boolean $format
     * @return mixed
     */
    protected function meta($id, $taxonomy, $key, $default = null, $format = true)
    {
        $value = null;

        if (function_exists('get_field')) {
            $value = get_field($key, $taxonomy.'_'.$id, $format);
        }

        if (is_null($value) || $value === false || $value === '') {
            $value = $default;
        }

        return $value;
    }
}
