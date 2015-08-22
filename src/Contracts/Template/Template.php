<?php

namespace Fire\Contracts\Template;

interface Template
{
    /**
     * Render a template
     *
     * @param  string  $key     Template name
     * @param  string  $suffix  Optional template suffix to check for first
     * @param  array   $data    Data to pass to template
     * @return string
     */
    public function render($key, $suffix = null, $data = []);

    /**
     * Get the full path to a template file
     *
     * @param  string  $key     Template name
     * @param  string  $suffix  Optional template suffix to check for first
     * @return string
     */
    public function find($key, $suffix = null);
}
