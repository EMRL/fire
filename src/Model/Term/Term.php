<?php

namespace Fire\Model\Term;

use Fire\Model\Entity;
use Fire\Contracts\Model\Term\Term as TermContract;

abstract class Term extends Entity implements TermContract
{
    protected $id;

    protected $name;

    protected $slug;

    protected $description;

    protected $taxonomy;

    /**
     * @var  Fire\Contracts\Model\Term\Term
     */
    protected $parent;

    /**
     * @var  array
     */
    protected $native;

    /**
     * Create a new post
     *
     * @param   $data  array
     * @return  void
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $prop => $value) {
            $method = 'set'.ucfirst($prop);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * Return the ID
     *
     * @return  integer
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Set the ID
     *
     * @param   $id  string|integer
     * @return  void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Return the name
     *
     * @return  string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Set the name
     *
     * @param   $name  string
     * @return  void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the slug
     *
     * @return  string
     */
    public function slug()
    {
        return $this->slug;
    }

    /**
     * Set the slug
     * @param   $slug  string
     * @return  void
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get the description
     *
     * @return  string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * Set the description
     *
     * @param   $description  string
     * @return  void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get the taxonomy
     *
     * @return  stdClass
     */
    public function taxonomy()
    {
        return $this->lazyLoad($this->taxonomy);
    }

    /**
     * Set the taxonomy
     *
     * @param   $taxonomy  string
     * @return  void
     */
    public function setTaxonomy($taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

    /**
     * Get the parent
     *
     * @return  Fire\Contracts\Model\Term\Term
     */
    public function parent()
    {
        return $this->lazyLoad($this->parent);
    }

    /**
     * Set the parent
     *
     * @param   $parent  Fire\Contracts\Model\Term\Term|Closure
     * @return  void
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get the original term array returned by WordPress
     *
     * @return  array
     */
    public function getNative()
    {
        return $this->native;
    }

    /**
     * Set the original term array returned by WordPress
     *
     * @param  $term  array
     */
    public function setNative(array $term)
    {
        $this->native = $term;
    }
}
