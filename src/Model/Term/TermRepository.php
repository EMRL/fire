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
    /**
     * @var string
     */
    protected $taxonomy;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var Fire\Contracts\Model\Term\Term
     */
    protected $currentTerm;

    /**
     * @param string  $taxonomy
     */
    public function __construct($taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

    /**
     * Return a term for the specified ID
     *
     * @param  integer  $id
     * @return Fire\Contracts\Term\Term
     */
    public function termOfId($id)
    {
        $term = get_term($id, $this->taxonomy, ARRAY_A);

        if ($term and ! $term instanceof WP_Error) {
            $term = $this->mapData($term);
        }

        return $term;
    }

    /**
     * Return a term for the specified slug
     *
     * @param  string  $slug
     * @return Fire\Contracts\Term\Term
     */
    public function termOfSlug($slug)
    {
        $term = get_term_by('slug', $slug, $this->taxonomy, ARRAY_A);

        if ($term) {
            $term = $this->mapData($term);
        }

        return $term;
    }

    /**
     * Return a collection of terms
     *
     * @param  Fire\Contracts\Foundation\Arrayable|array|null  $args
     * @return Fire\Foundation\Collection
     */
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

    /**
     * @return Fire\Contracts\Model\Term\Term
     */
    public function currentTerm()
    {
        return $this->currentTerm;
    }

    /**
     * @param Fire\Contracts\Model\Term\Term  $term
     */
    public function setCurrentTerm(TermContract $term)
    {
        $this->currentTerm = $term;
    }

    /**
     * Return a new params object
     *
     * @return Fire\Contracts\Foundation\Arrayable
     */
    public function newParams()
    {
        return new Params;
    }

    /**
     * @param string  $tax
     */
    public function setTaxonomy($tax)
    {
        $this->taxonomy = $tax;
    }
}
