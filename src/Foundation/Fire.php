<?php

namespace Fire\Foundation;

use Fire\Container\Container;
use Fire\Admin\Admin;
use Fire\Admin\RelativeUrls;

class Fire extends Container
{
    public function __construct()
    {
        $this->registerBaseBindings();
        $this->loadBaseFiles();

        do_action('fire/services', $this);
        do_action('fire/ignite', $this);
    }

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

    protected function loadBaseFiles()
    {
        $files = [
            'src/Foundation/helpers.php',
            'src/Admin/services.php',
            'src/Filesystem/services.php',
            'src/Template/services.php',
            'src/Template/helpers.php',
            'src/Model/Post/services.php',
            'src/Model/Page/services.php',
            'src/Model/Category/services.php',
            'src/Model/Tag/services.php',
            'src/Model/User/services.php',
            'src/Model/Upload/services.php',
        ];

        foreach ($files as $file) {
            include $this['path.fire'].$file;
        }
    }
}
