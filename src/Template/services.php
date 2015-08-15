<?php

namespace Fire\Template;

add_action('fire/services', function($fire)
{
	$fire->singleton('template.finder', function($fire)
	{
		return new FileTemplateFinder($fire['filesystem'], [$fire['path.fire'].'templates']);
	});

	$fire->singleton('template', function($fire)
	{
		return new Template($fire['template.finder']);
	});
}, 5);