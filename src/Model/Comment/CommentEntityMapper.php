<?php

namespace Fire\Model\Comment;

use Fire\Contracts\Model\EntityMapper as EntityMapperContract;
use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\Post\PostRepository as PostRepositoryContract;
use Fire\Contracts\Model\Comment\CommentRepository as CommentRepositoryContract;
use Fire\Contracts\Model\User\UserRepository as UserRepositoryContract;

class CommentEntityMapper implements EntityMapperContract
{
    protected $postRepository;

    protected $commentRepository;

    protected $userRepository;

    public function __construct(
        PostRepositoryContract $postRepository,
        CommentRepositoryContract $commentRepository,
        UserRepositoryContract $userRepository
    ) {
        $this->postRepository    = $postRepository;
        $this->commentRepository = $commentRepository;
        $this->userRepository    = $userRepository;
    }

    public function map(EntityContract $entity, array $data)
    {
        $entity->setId($data['comment_ID']);
        $entity->setPostId($id = $data['comment_post_ID']);

        $entity->setPost(function () use ($id) {
            return $this->postRepository->postOfId($id);
        });

        $entity->setAuthorName($data['comment_author']);
        $entity->setAuthorEmail($data['comment_author_email']);
        $entity->setAuthorUrl($data['comment_author_url']);
        $entity->setAuthorIp($data['comment_author_IP']);
        $entity->setDate($data['comment_date']);
        $entity->setContent($data['comment_content']);
        $entity->setStatus($data['comment_approved']);
        $entity->setUserAgent($data['comment_agent']);
        $entity->setType($data['comment_type']);
        $entity->setParentId($id = $data['comment_parent']);

        $entity->setParent(function () use ($id) {
            $parent = null;

            if ($id) {
                $parent = $this->commentRepository->commentOfId($id);
            }

            return $parent;
        });

        $entity->setUserId($id = $data['user_id']);

        $entity->setUser(function () use ($id) {
            $user = null;

            if ($id) {
                $user = $this->userRepository->userOfId($id);
            }

            return $user;
        });
    }
}
