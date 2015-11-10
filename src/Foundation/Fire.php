<?php

namespace Fire\Foundation;

use Fire\Container\Container;
use Fire\Admin\Admin;
use Fire\Admin\RelativeUrls;

class Fire extends Container
{
    /**
     * Create new instance of Fire
     *
     * Loads required files and binds services to container
     */
    public function __construct()
    {
        $this->registerBaseBindings();
        $this->loadBaseFiles();
        $this->debug();

        do_action('fire/services/core', $this);

        add_action('muplugins_loaded', function () {
            do_action('fire/services/required', $this);
        });

        add_action('plugins_loaded', function () {
            do_action('fire/services/plugin', $this);
        });

        add_action('after_setup_theme', function () {
            do_action('fire/services/parent', $this);
            do_action('fire/services/theme', $this);
            do_action('fire/ignite', $this);
        }, 20);
    }

    /**
     * Register core services
     */
    protected function registerBaseBindings()
    {
        static::setInstance($this);

        $this->instance('fire', $this);
        $this->instance('Fire\Container\Container', $this);

        $this->instance('path.fire', FIRE_PATH);
        $this->instance('url.fire',  FIRE_URL);
        $this->instance('path.parent', trailingslashit(get_template_directory()));
        $this->instance('url.parent', trailingslashit(get_template_directory_uri()));
        $this->instance('path.theme', trailingslashit(get_stylesheet_directory()));
        $this->instance('url.theme', trailingslashit(get_stylesheet_directory_uri()));
    }

    /**
     * Load service providers and helpers
     */
    protected function loadBaseFiles()
    {
        $files = [
            'src/Foundation/services.php',
            'src/Foundation/helpers.php',
            'src/Admin/services.php',
            'src/Asset/services.php',
            'src/Asset/helpers.php',
            'src/Filesystem/services.php',
            'src/Template/services.php',
            'src/Template/helpers.php',
            'src/Model/AbstractPost/services.php',
            'src/Model/Term/services.php',
            'src/Model/Post/services.php',
            'src/Model/Page/services.php',
            'src/Model/Category/services.php',
            'src/Model/Tag/services.php',
            'src/Model/User/services.php',
            'src/Model/Upload/services.php',
            'src/Model/Comment/services.php',
        ];

        foreach ($files as $file) {
            include $this['path.fire'].$file;
        }
    }

    protected function debug()
    {
        if (isset($_GET['debug'])) {
            add_action('shutdown', function () {
                global $wpdb;

                d($wpdb->queries);
            });
        }
    }
}
