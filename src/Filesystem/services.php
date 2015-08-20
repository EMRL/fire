<?php

namespace Fire\Filesystem;

add_action('fire/services/core', function ($fire) {
	$fire->singleton('filesystem', function () {
		return new Filesystem;
	});
});
