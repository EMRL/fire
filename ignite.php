<?php
/**
 * Plugin Name: Fire WordPress Framework
 *
 * @author  Corey Worrell, EMRL
 * @link    http://emrl.com
 * @version 2.0.0
 */

add_action('after_setup_theme', function()
{
	define('FIRE_PATH', trailingslashit(__DIR__));
	define('FIRE_URL', trailingslashit(WP_PLUGIN_URL.basename(__DIR__)));

	include __DIR__.'/src/Foundation/Psr4Autoloader.php';

	$loader = new Fire\Foundation\Psr4Autoloader;
	$loader->register();
	$loader->addNamespace('Fire', __DIR__.'/src');

	$fire = new Fire\Foundation\Fire();
	$fire->instance('classLoader', $loader);
	$fire->registerServices();
	$fire->ignite();

	echo '<pre>'.print_r($fire['repository.post']->postOfId(1)->categories(), TRUE).'</pre>';die;
});