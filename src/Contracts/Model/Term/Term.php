<?php

namespace Fire\Contracts\Model\Term;

interface Term
{
    public function id();
    public function setId($id);

    public function name();
    public function setName($name);

    public function slug();
    public function setSlug($slug);

    public function description();
    public function setDescription($description);

    public function taxonomy();
    public function setTaxonomy($taxonomy);

    public function parent();
    public function setParent($parent);
}
