<?php

namespace Fire\Admin;

add_action('fire/services/core', function ($fire) {
    if (current_theme_supports('relative-urls')) {
        new RelativeUrls;
    }
});
