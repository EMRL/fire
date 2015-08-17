<?php
/**
 * Plugin Name: Fire WordPress Framework
 *
 * @author  Corey Worrell, EMRL
 * @link    http://emrl.com
 * @version 2.0.0
 */

define('FIRE_PATH', trailingslashit(__DIR__));
define('FIRE_URL', trailingslashit(WP_PLUGIN_URL.basename(__DIR__)));

add_action('after_setup_theme', function()
{
	include __DIR__.'/src/Foundation/Psr4Autoloader.php';

	$loader = new Fire\Foundation\Psr4Autoloader;
	$loader->register();
	$loader->addNamespace('Fire', __DIR__.'/src');

	do_action('fire/autoload', $loader);

	$fire = new Fire\Foundation\Fire;
	$fire->instance('psr4.autoloader', $loader);
});
