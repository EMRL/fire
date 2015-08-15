<?php

namespace Fire\Filesystem;

add_action('fire/services', function($fire)
{
	$fire->singleton('filesystem', function()
	{
		return new Filesystem;
	});
}, 5);