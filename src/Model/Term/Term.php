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

    public function taxonomy()
    {
        return $this->lazyLoad($this->taxonomy);
    }

    public function setTaxonomy($taxonomy)
    {
        $this->taxonomy = $taxonomy;
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
