<?php

namespace Fire\Model\AbstractPost;

add_action('fire/services/core', function ($fire) {
    $fire->instance('abstractpost.entitymapper', function () use ($fire) {
        return new AbstractPostEntityMapper(
            $fire['user.repository'],
            $fire['upload.repository'],
            $fire['comment.repository']
        );
    });
});
