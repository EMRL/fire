<?php

namespace Fire\Model\Post;

use Fire\Model\AbstractPost\AbstractPostEntityMapper;

add_action('fire/services/core', function ($fire) {
    $fire->singleton('post.repository', function ($fire) {
        $repo = new PostRepository(PostPostType::TYPE);

        $repo->registerEntityMapper(function () use ($fire) {
            return new AbstractPostEntityMapper(
                $fire['user.repository'],
                $fire['upload.repository']
            );
        });

        $repo->registerEntityMapper(function () use ($fire) {
            return new PostEntityMapper(
                $fire['post.repository'],
                $fire['category.repository'],
                $fire['tag.repository']
            );
        });

        return $repo;
    });
});
