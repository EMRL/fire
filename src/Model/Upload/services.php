<?php

use Fire\Model\Upload;

use Fire\Model\AbstractPost\AbstractPostEntityMapper;

add_action('fire/services', function ($fire) {
    $fire->singleton('upload.repository', function ($fire) {
        $repo = new UploadRepository(UploadPostType::TYPE);

        $repo->registerEntityMapper(function () use ($fire) {
            return new AbstractPostEntityMapper($fire['user.repository']);
        });

        $repo->registerEntityMapper(function () use ($fire) {
            return new UploadEntityMapper;
        });

        return $repo;
    });
}, 5);
