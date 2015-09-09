<?php

namespace Fire\Model\Page;

use Fire\Model\AbstractPost\AbstractPostRepository;
use Fire\Contracts\Model\Page\PageRepository as PageRepositoryContract;
use Fire\Contracts\Model\Page\Page as PageContract;

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

    /**
     * Get the current requested page
     *
     * @return Fire\Contract\Model\Page\Page
     */
    public function currentPage()
    {
        return $this->currentPost();
    }

    /**
     * Set the current requested page
     *
     * @param Fire\Contract\Model\Page\Page  $page
     */
    public function setCurrentPage(Page $page)
    {
        $this->currentPost = $page;
    }

    public function newParams()
    {
        return new PageParams($this->postType);
    }
}
