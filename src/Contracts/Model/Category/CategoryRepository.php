<?php

namespace Fire\Contracts\Model\Category;

interface CategoryRepository
{
    /**
     * Return a category for the specified ID
     *
     * @param  integer  $id
     * @return Fire\Contracts\Category\Category
     */
    public function categoryOfId($id);

    /**
     * Return a category for the specified slug
     *
     * @param  string  $slug
     * @return Fire\Contracts\Category\Category
     */
    public function categoryOfSlug($slug);

    /**
     * Return a collection of categories
     *
     * @param  Fire\Contracts\Foundation\Arrayable|array|null  $args
     * @return Fire\Foundation\Collection
     */
    public function find($args = null);
}
