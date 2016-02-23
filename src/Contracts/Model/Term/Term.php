<?php

namespace Fire\Contracts\Model\Term;

interface Term
{
    /**
     * Return the ID
     *
     * @return integer
     */
    public function id();

    /**
     * Set the ID
     *
     * @param integer
     */
    public function setId($id);

    /**
     * Return the name
     *
     * @return string
     */
    public function name();

    /**
     * Set the name
     *
     * @param string  $name
     */
    public function setName($name);

    /**
     * Get the slug
     *
     * @return string
     */
    public function slug();

    /**
     * Set the slug
     *
     * @param string  $slug
     */
    public function setSlug($slug);

    /**
     * Get the description
     *
     * @return string
     */
    public function description();

    /**
     * Set the description
     *
     * @param string  $description
     */
    public function setDescription($description);

    /**
     * Get the count
     *
     * @return int
     */
    public function count();

    /**
     * Set the count
     *
     * @param int  $count
     */
    public function setCount($count);

    /**
     * Get the taxonomy
     *
     * @return stdClass
     */
    public function taxonomy();

    /**
     * Set the taxonomy
     *
     * @param string  $taxonomy
     */
    public function setTaxonomy($taxonomy);

    /**
     * Get the parent
     *
     * @return Fire\Contracts\Model\Term\Term
     */
    public function parent();

    /**
     * Set the parent
     *
     * @param Fire\Contracts\Model\Term\Term|Closure  $parent
     */
    public function setParent($parent);
}
