<?php

namespace Fire\Admin;

add_action('fire/ignite', function ($fire) {
    if (apply_filters('fire/relative-urls', true)) {
        new RelativeUrls;
    }
});
