<?php

namespace Fire\Model\Category;

use Fire\Model\Term\TermRepository;
use Fire\Contracts\Model\Category\CategoryRepository as CategoryRepositoryContract;

class CategoryRepository extends TermRepository implements CategoryRepositoryContract
{
    protected $entityClass = 'Fire\Model\Category\Category';

    public function categoryOfId($id)
    {
        return $this->termOfId($id);
    }

    public function categoryOfSlug($slug)
    {
        return $this->termOfSlug($slug);
    }

    protected function newParams()
    {
        return new CategoryParams($this->taxonomy);
    }
}
