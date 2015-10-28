<?php

namespace Fire\Model\Page;

use Fire\Model\AbstractPost\AbstractPostEntityMapper;

add_action('fire/services/core', function ($fire) {
    $fire->singleton('page.repository', function ($fire) {
        $repo = new PageRepository(PagePostType::TYPE);

        $repo->registerEntityMapper($fire['abstractpost.entitymapper']);

        $repo->registerEntityMapper(function () use ($fire) {
            return new PageEntityMapper($fire['page.repository']);
        });

        return $repo;
    });
});
