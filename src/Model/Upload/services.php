<?php

namespace Fire\Model\Upload;

use Fire\Model\AbstractPost\AbstractPostEntityMapper;

add_action('fire/services/core', function ($fire) {
    $fire->singleton('upload.repository', function ($fire) {
        $repo = new UploadRepository(UploadPostType::TYPE);

        $repo->registerEntityMapper(function () use ($fire) {
            return new AbstractPostEntityMapper(
                $fire['user.repository'],
                $fire['upload.repository'],
                $fire['comment.repository']
            );
        });

        $repo->registerEntityMapper(function () use ($fire) {
            return new UploadEntityMapper;
        });

        return $repo;
    });
});
