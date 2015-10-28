<?php

namespace Fire\Model\Upload;

use Fire\Model\AbstractPost\AbstractPostEntityMapper;

add_action('fire/services/core', function ($fire) {
    $fire->singleton('upload.repository', function ($fire) {
        $repo = new UploadRepository(UploadPostType::TYPE);

        $repo->registerEntityMapper($fire['abstractpost.entitymapper']);

        $repo->registerEntityMapper(function () use ($fire) {
            return new UploadEntityMapper;
        });

        return $repo;
    });
});
