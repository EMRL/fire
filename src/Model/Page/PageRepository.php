<?php

namespace Fire\Model\Page;

use Fire\Model\AbstractPost\AbstractPostRepository;
use Fire\Contracts\Model\Page\PageRepository as PageRepositoryContract;

class PageRepository extends AbstractPostRepository implements PageRepositoryContract
{
    protected $entityClass = 'Fire\Model\Page\Page';

    public function pageOfId($id)
    {
        return $this->postOfId($id);
    }

    public function pageOfSlug($slug)
    {
        return $this->postOfSlug($slug);
    }

    protected function newParams()
    {
        return new PageParams($this->postType);
    }
}
