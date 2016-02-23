<?php

namespace Fire\Model\Term;

use Fire\Model\Entity;
use Fire\Contracts\Model\Term\Term as TermContract;

abstract class Term extends Entity implements TermContract
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var integer
     */
    protected $count;

    /**
     * @var stdClass
     */
    protected $taxonomy;

    /**
     * @var integer
     */
    protected $parentId;

    /**
     * @var Fire\Contracts\Model\Term\Term
     */
    protected $parent;

    /**
     * @var array
     */
    protected $native;

    /**
     * Create a new post
     *
     * @param  array  $data
     * @return void
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

    public function id()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function name()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function slug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }


    public function description()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function count()
    {
        return $this->count;
    }

    public function setCount($count)
    {
        return $this->count = $count;
    }

    public function taxonomy()
    {
        return $this->lazyLoad($this->taxonomy);
    }

    public function setTaxonomy($taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

    public function parentId()
    {
        return $this->parentId;
    }

    public function setParentId($id)
    {
        $this->parentId = $id;
    }

    public function parent()
    {
        return $this->lazyLoad($this->parent);
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get the URL to term archive
     *
     * @return  string
     */
    public function url()
    {
        return get_term_link($this->id(), $this->taxonomy()->name);
    }

    /**
     * Get the original term array returned by WordPress
     *
     * @return array
     */
    public function getNative()
    {
        return $this->native;
    }

    /**
     * Set the original term array returned by WordPress
     *
     * @param array  $term
     */
    public function setNative(array $term)
    {
        $this->native = $term;
    }
}
