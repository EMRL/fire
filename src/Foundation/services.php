<?php

namespace Fire\Foundation;

add_action('fire/services', function ($fire) {
    $fire->instance('request', new Request(
        $fire['post.repository'],
        $fire['page.repository']
    ));
}, '5.1');
