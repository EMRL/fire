<?php

namespace Fire\Template;

class Layout
{
    /**
     * Path to theme templates
     *
     * @var string
     */
    protected $themePath;

    /**
     * The current template file that WordPress found
     *
     * @var string
     */
    protected $template;

    /**
     * Layouts for template files
     *
     * @var array
     */
    protected $layouts = [];

    /**
     * @param string  $themePath
     */
    public function __construct($themePath)
    {
        $this->themePath = $themePath;

        add_filter('template_include', function ($template) {
            if ( ! current_theme_supports('fire/layouts')) {
                return $template;
            }

            $this->template = $template;

            $name = str_replace($this->themePath, '', $template);

            $layouts = ['layout.php'];

            if (isset($this->layouts[$name])) {
                array_unshift($layouts, $this->layouts[$name]);
            }

            return locate_template($layouts);
        }, 1000);
    }

    /**
     * Return the template contents
     *
     * @return string
     */
    public function content()
    {
        ob_start();
        load_template($this->template);
        return ob_get_clean();
    }

    /**
     * Add a layout for a template
     *
     * @param string  $template
     * @param string  $layout
     */
    public function addLayout($template, $layout = null)
    {
        if ( ! is_array($template)) {
            $template = [$template => $layout];
        }

        $this->layouts = array_merge($this->layouts, $template);

        return $this;
    }
}
