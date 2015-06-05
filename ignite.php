<?php
/**
 * Plugin Name: Fire WordPress Framework
 *
 * @author  Corey Worrell, EMRL
 * @link    http://emrl.com
 * @version 2.0.0
 */

include __DIR__.'/src/Foundation/Psr4Autoloader.php';

$loader = new Fire\Foundation\Psr4Autoloader;
$loader->register();
$loader->addNamespace('Fire', __DIR__.'/src');