<?php
/**
 * Plugin Name: Fire WordPress Framework
 *
 * @author Corey Worrell, EMRL
 * @link http://emrl.com
 * @version 2.3.1
 */

define('FIRE_PATH', __DIR__.'/');
define('FIRE_URL', WP_PLUGIN_URL.basename(__DIR__).'/');

// Fallback autoloader for when Composer not setup
include __DIR__.'/src/Foundation/Psr4Autoloader.php';

$loader = new Fire\Foundation\Psr4Autoloader;
$loader->register();

if ( ! class_exists('Fire\Foundation\Fire')) {
    $loader->addNamespace('Fire', __DIR__.'/src');
}

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

unset($loader, $fire);
