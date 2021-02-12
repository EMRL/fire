<?php

declare(strict_types=1);

namespace Fire\Template;

class Layout
{
    protected string $default;

    protected int $priority = 999;

    /** @var array<string,string> $layouts */
    protected array $layouts = [];

    protected string $current;

    public function __construct(string $default = 'layout.php')
    {
        $this->setDefault($default);
    }

    public function setDefault(string $value): self
    {
        $this->default = $value;
        return $this;
    }

    public function setPriority(int $value): self
    {
        $this->priority = $value;
        return $this;
    }

    public function setLayoutFor(string $template, string $layout): self
    {
        $this->layouts[$template] = $layout;
        return $this;
    }

    public function register(): self
    {
        add_filter('template_include', [$this, 'include'], $this->priority);
        return $this;
    }

    public function include(string $template): string
    {
        return locate_template($this->layoutsForTemplate($template));
    }

    public function layoutsForTemplate(string $template): array
    {
        $base = $template;
        $layouts = [$this->default];
        $this->current = $template;

        if (strpos($template, get_theme_file_path()) === 0) {
            $base = basename($template);
        }

        if (isset($this->layouts[$base])) {
            array_unshift($layouts, $this->layouts[$base]);
        }

        return $layouts;
    }

    public function current(): string
    {
        return $this->current;
    }

    public function __toString(): string
    {
        return buffer(function (): void {
            load_template($this->current());
        });
    }
}
