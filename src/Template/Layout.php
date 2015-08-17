<?php

namespace Fire\Template;

class Layout
{
    protected $themePath;

    protected $template;

    protected $layouts = [];

    public function __construct($themePath)
    {
        $this->themePath = $themePath;

        add_filter('template_include', function ($template) {
            $this->template = $template;

            $name = str_replace($this->themePath, '', $template);

            $layouts = ['layout.php'];

            if (isset($this->layouts[$name])) {
                array_unshift($layouts, $this->layouts[$name]);
            }

            return locate_template($layouts);
        }, 1000);
    }

    public function content()
    {
        ob_start();
        load_template($this->template);
        return ob_get_clean();
    }

    public function addLayout($template, $layout = null)
    {
        if ( ! is_array($template)) {
            $template = [$template => $layout];
        }

        $this->layouts = array_merge($this->layouts, $template);

        return $this;
    }
}
