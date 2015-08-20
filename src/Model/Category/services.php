<?php

namespace Fire\Model\Category;

use Fire\Model\Term\TermEntityMapper;

add_action('fire/services/core', function ($fire) {
    $fire->singleton('category.repository', function ($fire) {
        $repo = new CategoryRepository(CategoryTaxonomy::NAME);

        $repo->registerEntityMapper(function () {
            return new TermEntityMapper;
        });

        $repo->registerEntityMapper(function () use ($fire) {
            return new CategoryEntityMapper(
                $fire['category.repository'],
                $fire['post.repository']
            );
        });

        return $repo;
    });
});
