<?php

namespace Fire\Model\Tag;

use Fire\Model\Term\TermRepository;
use Fire\Contracts\Model\Tag\TagRepository as TagRepositoryContract;

class TagRepository extends TermRepository implements TagRepositoryContract
{
    protected $entityClass = 'Fire\Model\Tag\Tag';

    public function tagOfId($id)
    {
        return $this->termOfId($id);
    }

    public function tagOfSlug($slug)
    {
        return $this->termOfSlug($slug);
    }

    public function newParams()
    {
        return new TagParams($this->taxonomy);
    }
}
