<?php

namespace Fire\Model\User;

add_action('fire/services/core', function ($fire) {
    $fire->singleton('user.repository', function ($fire) {
        $repo = new UserRepository;

        $repo->registerEntityMapper(function () use ($fire) {
            return new UserEntityMapper(
                $fire['post.repository'],
                $fire['page.repository'],
                $fire['comment.repository']
            );
        });

        return $repo;
    });
});
