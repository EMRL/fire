<?php

namespace Fire\Model\Term;

use Fire\Foundation\Params;

class TermParams extends Params
{
    /**
     * @var string
     */
    protected $taxonomy;

    /**
     * @param string $taxonomy
     */
    public function __construct($taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

    protected function defaultParams()
    {
        return [
            'hide_empty' => false,
        ];
    }
}
