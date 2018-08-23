<?php

namespace Fire\Foundation;

use Fire\Contracts\Foundation\Arrayable;

class Params implements Arrayable
{
    /**
     * List of parameters
     *
     * @var array
     */
    protected $params = [];

    /**
     * Add params, overwriting previous values with same keys
     *
     * @param string|array $params
     * @param mixed $value
     * @return $this
     */
    public function add($params, $value = null)
    {
        if ( ! is_array($params)) {
            $params = array($params => $value);
        }

        $this->params = array_replace_recursive($this->params, $params);

        return $this;
    }

    /**
     * Add params, but merge previous values with same keys
     *
     * @param string|array $params
     * @param mixed $value
     * @return $this
     */
    public function merge($params, $value = null)
    {
        if ( ! is_array($params)) {
            $params = array($params => $value);
        }

        $this->params = array_merge_recursive($this->params, $params);

        return $this;
    }

    /**
     * Reset params back to their default state
     *
     * @return $this
     */
    public function reset()
    {
        $this->params = $this->defaultParams();

        return $this;
    }

    /**
     * Get all parameters
     *
     * @return array
     */
    public function toArray()
    {
        return array_replace_recursive($this->defaultParams(), $this->params);
    }

    /**
     * Set default parameters
     *
     * @return array
     */
    protected function defaultParams()
    {
        return [];
    }
}
