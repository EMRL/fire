<?php

namespace Fire\Template;

add_action('fire/services/core', function ($fire) {
    $fire->singleton('template.finder', function ($fire) {
        return new FileTemplateFinder($fire['filesystem'], [$fire['path.fire'].'templates']);
    });

    $fire->instance('template.layout', new Layout($fire['path.theme']));

    $fire->singleton('template', function ($fire) {
        return new Template($fire['template.finder']);
    });
});
