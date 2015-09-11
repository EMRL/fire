<?php
/**
 * Plugin Name: Fire WordPress Framework
 *
 * @author  Corey Worrell, EMRL
 * @link    http://emrl.com
 * @version 2.0.4
 */

define('FIRE_PATH', trailingslashit(__DIR__));
define('FIRE_URL', trailingslashit(WP_PLUGIN_URL.basename(__DIR__)));

include __DIR__.'/src/Foundation/Psr4Autoloader.php';

$loader = new Fire\Foundation\Psr4Autoloader;
$loader->register();
$loader->addNamespace('Fire', __DIR__.'/src');

add_action('muplugins_loaded', function () use ($loader) {
    do_action('fire/autoload/required', $loader);
});

add_action('plugins_loaded', function () use ($loader) {
    do_action('fire/autoload/plugin', $loader);
});

add_action('after_setup_theme', function () use ($loader) {
    do_action('fire/autoload/parent', $loader);
    do_action('fire/autoload/theme', $loader);
});

$fire = new Fire\Foundation\Fire;
$fire->instance('psr4.autoloader', $loader);
