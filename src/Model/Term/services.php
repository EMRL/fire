<?php

namespace Fire\Model\Term;

add_action('fire/services/core', function ($fire) {
    $fire->instance('term.entitymapper', function() use ($fire) {
        return new TermEntityMapper;
    });
});
