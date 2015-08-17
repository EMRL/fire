<?php

namespace Fire\Contracts\Model\Tag;

interface TagRepository
{
    public function tagOfId($id);

    public function tagOfSlug($slug);

    public function find($args = null);
}
