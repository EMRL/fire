<?php

namespace Fire\Model\User;

use Fire\Contracts\Model\EntityMapper as EntityMapperContract;
use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\Post\PostRepository as PostRepositoryContract;
use Fire\Contracts\Model\Page\PageRepository as PageRepositoryContract;
use Fire\Contracts\Model\Comment\CommentRepository as CommentRepositoryContract;

class UserEntityMapper implements EntityMapperContract
{
    /**
     * @var Fire\Contracts\Model\Post\PostRepository
     */
    protected $postRepository;

    /**
     * @var Fire\Contracts\Model\Page\PageRepository
     */
    protected $pageRepository;

    /**
     * @var Fire\Contracts\Model\Comment\CommentRepository
     */
    protected $commentRepository;

    public function __construct(
        PostRepositoryContract $postRepository,
        PageRepositoryContract $pageRepository,
        CommentRepositoryContract $commentRepository
    ) {
        $this->postRepository    = $postRepository;
        $this->pageRepository    = $pageRepository;
        $this->commentRepository = $commentRepository;
    }

    public function map(EntityContract $entity, array $data)
    {
        $entity->init((object) $data);

        $id = $data['ID'];

        $entity->setPosts(function () use ($id) {
            return $this->postRepository->postsByAuthor($id);
        });

        $entity->setPages(function () use ($id) {
            return $this->pageRepository->pagesByAuthor($id);
        });

        $entity->setComments(function () use ($id) {
            return $this->commentRepository->commentsByAuthor($id);
        });
    }
}
