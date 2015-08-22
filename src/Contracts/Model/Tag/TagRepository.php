<?php

namespace Fire\Contracts\Model\Tag;

interface TagRepository
{
    /**
     * Return a tag for the specified ID
     *
     * @param  integer  $id
     * @return Fire\Contracts\Tag\Tag
     */
    public function tagOfId($id);

    /**
     * Return a tag for the specified slug
     *
     * @param  string  $slug
     * @return Fire\Contracts\Tag\Tag
     */
    public function tagOfSlug($slug);

    /**
     * Return a collection of tags
     *
     * @param  Fire\Contracts\Foundation\Arrayable|array|null  $args
     * @return Fire\Foundation\Collection
     */
    public function find($args = null);
}
