<?php

namespace Fire\Contracts\Model\Page;

interface PageRepository
{
    /**
     * Return a page of the specified ID
     *
     * @param  integer  $id
     * @return Fire\Contracts\Page\Page
     */
    public function pageOfId($id);

    /**
     * Return a page of the specified slug
     *
     * @param  string  $slug
     * @return Fire\Contracts\Page\Page
     */
    public function pageOfSlug($slug);

    /**
     * Return a collection of pages
     *
     * @param  Fire\Contracts\Foundation\Arrayable|array|null  $args
     * @return Fire\Foundation\Collection
     */
    public function find($args = null);
}
