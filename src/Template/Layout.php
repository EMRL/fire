<?php

declare(strict_types=1);

namespace Fire\Template;

class Layout
{
    protected string $default;

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

    public function setLayoutFor(string $template, string $layout): self
    {
        $this->layouts[$template] = $layout;
        return $this;
    }

    public function register(): self
    {
        add_filter('template_include', [$this, 'include']);
        return $this;
    }

    public function include(string $template): string
    {
        return locate_template($this->layoutsForTemplate($template));
    }

    public function layoutsForTemplate(string $template): array
    {
        $layouts = [$this->default];
        $this->current = basename($template);

        if (isset($this->layouts[$this->current])) {
            array_unshift($layouts, $this->layouts[$this->current]);
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
            locate_template([$this->current()], true);
        });
    }
}
