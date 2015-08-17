<?php

namespace Fire\Model\Page;

use Fire\Model\AbstractPost\AbstractPostEntityMapper;

add_action('fire/services', function ($fire) {
    $fire->singleton('page.repository', function ($fire) {
        $repo = new PageRepository(PagePostType::TYPE);

        $repo->registerEntityMapper(function () use ($fire) {
            return new AbstractPostEntityMapper($fire['user.repository']);
        });

        $repo->registerEntityMapper(function () use ($fire) {
            return new PageEntityMapper($fire['page.repository']);
        });

        return $repo;
    });
}, 5);
