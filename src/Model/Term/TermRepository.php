<?php

namespace Fire\Model\Term;

use WP_Error;
use Fire\Model\Repository;
use Fire\Foundation\Collection;
use Fire\Foundation\Params;
use Fire\Contracts\Foundation\Arrayable;
use Fire\Contracts\Model\Term\Term as TermContract;

abstract class TermRepository extends Repository
{
    protected $taxonomy;

    protected $entityClass;

    /**
     * @var  Fire\Contracts\Model\Term\Term
     */
    protected $currentTerm;

    public function __construct($taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

    public function termOfId($id)
    {
        $term = get_term($id, $this->taxonomy, ARRAY_A);

        if ($term and ! $term instanceof WP_Error) {
            $term = $this->mapData($term);
        }

        return $term;
    }

    public function termOfSlug($slug)
    {
        $term = get_term_by('slug', $slug, $this->taxonomy, ARRAY_A);

        if ($term) {
            $term = $this->mapData($term);
        }

        return $term;
    }

    public function find($args = null)
    {
        if (is_null($args)) {
            $args = $this->newParams();
        }

        $args = ($args instanceof Arrayable) ? $args->toArray() : $args;

        $terms = new Collection;

        foreach (get_terms($this->taxonomy, $args) as $term) {
            $terms->push($this->termOfId($term->term_id));
        }

        return $terms;
    }

    public function currentTerm()
    {
        return $this->currentTerm;
    }

    public function setCurrentTerm(TermContract $term)
    {
        $this->currentTerm = $term;
    }

    protected function newParams()
    {
        return new Params;
    }

    public function setTaxonomy($tax)
    {
        $this->taxonomy = $tax;
    }
}
