<?php

namespace Fire\Model\Comment;

add_action('fire/services/core', function ($fire) {
    $fire->singleton('comment.repository', function ($fire) {
        $repo = new CommentRepository;

        $repo->registerEntityMapper(function () use ($fire) {
            return new CommentEntityMapper(
                $fire['post.repository'],
                $fire['comment.repository'],
                $fire['user.repository'],
                $fire['comment.repository']
            );
        });

        return $repo;
    });
});
