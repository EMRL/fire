<?php

namespace Fire\Foundation;

add_action('fire/services/core', function ($fire) {
    $fire->instance('request', new Request(
        $fire['post.repository'],
        $fire['page.repository']
    ));
}, 11);
