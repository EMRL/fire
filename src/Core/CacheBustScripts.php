<?php

declare(strict_types=1);

namespace Fire\Core;

use InvalidArgumentException;

class CacheBustScripts
{
    protected int $hashLength = 10;

    /** @var string[] */
    protected array $validHosts;

    public function __construct(string ...$validHosts)
    {
        $this->validHosts = parse_hosts(...$validHosts ?: [home_url()]);

        if (empty($this->validHosts)) {
            throw new InvalidArgumentException('No valid hosts for `CacheBustScripts`');
        }
    }

    public function register(): self
    {
        if (is_admin()) {
            return $this;
        }

        add_filter('script_loader_src', [$this, 'src']);
        add_filter('style_loader_src', [$this, 'src']);
        return $this;
    }

    public function src(string $src): string
    {
        $url = parse_url($src);

        // Return if host does not match
        if (
            empty($url['host']) ||
            empty($url['query']) ||
            !in_array($url['host'], $this->validHosts(), true)
        ) {
            return $src;
        }

        // Get version
        parse_str($url['query'], $query);
        $ver = $query['ver'] ?? null;

        if (!$ver) {
            return $src;
        }

        // Remove version and append to filename
        $src = remove_query_arg('ver', $src);
        $ver = substr(sha1($ver), 0, $this->hashLength);
        return preg_replace('/\.(js|css)(\?.*)?$/', ".$ver.\$1\$2", $src);
    }

    public function setHashLength(int $length): self
    {
        $this->hashLength = $length;
        return $this;
    }

    public function validHosts(): array
    {
        return $this->validHosts;
    }
}
