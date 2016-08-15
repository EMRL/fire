<?php

namespace Fire\Template;

add_action('fire/services/core', function ($fire) {
    $fire->singleton('template.finder', function ($fire) {
        return new FileTemplateFinder($fire['filesystem'], [$fire['path.fire'].'templates']);
    });

    $fire->singleton('template', function ($fire) {
        return new Template($fire['template.finder']);
    });
});

add_action('fire/ignite', function ($fire) {
    if (apply_filters('fire/use-layout', true)) {
        $fire->instance('template.layout', new Layout($fire['path.theme']));
    }
});

