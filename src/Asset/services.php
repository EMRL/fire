<?php

namespace Fire\Asset;

add_action('fire/services/core', function ($fire) {
    $fire->singleton('asset.finder', function ($fire) {
        return new FileAssetFinder($fire['filesystem'], [$fire['path.fire'].'assets']);
    });

    $fire->singleton('asset', function ($fire) {
        return new Asset($fire['asset.finder']);
    });
});
