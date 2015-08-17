<?php

namespace Fire\Model\Page;

use Fire\Contracts\Model\EntityMapper as EntityMapperContract;
use Fire\Contracts\Model\Page\PageRepository as PageRepositoryContract;
use Fire\Contracts\Model\Entity as EntityContract;

class PageEntityMapper implements EntityMapperContract
{
    protected $pageRepository;

    public function __construct(PageRepositoryContract $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function map(EntityContract $entity, array $data)
    {
        $id = $data['post_parent'];

        $entity->setParent(function () use ($id) {
            $parent = null;

            if ($id) {
                $parent = $this->pageRepository->pageOfId($id);
            }

            return $parent;
        });
    }
}
