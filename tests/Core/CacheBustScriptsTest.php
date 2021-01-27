<?php

declare(strict_types=1);

namespace Fire\Tests\Core;

use Fire\Core\CacheBustScripts;
use Fire\Tests\TestCase;
use InvalidArgumentException;

use function Brain\Monkey\Functions\when;
use function Fire\Core\parse_hosts;

final class CacheBustScriptsTest extends TestCase
{
    protected string $current = 'https://domain.com';

    public function testFiltersAdded(): void
    {
        when('is_admin')->justReturn(false);
        $instance = (new CacheBustScripts($this->current))->register();
        $this->assertIsInt(has_filter('script_loader_src', [$instance, 'src']));
        $this->assertIsInt(has_filter('style_loader_src', [$instance, 'src']));
    }

    public function testFiltersNotAddedForAdmin(): void
    {
        when('is_admin')->justReturn(true);
        $instance = (new CacheBustScripts($this->current))->register();
        $this->assertFalse(has_filter('script_loader_src', [$instance, 'src']));
        $this->assertFalse(has_filter('style_loader_src', [$instance, 'src']));
    }

    public function testNoValidHosts(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new CacheBustScripts('//');
    }

    public function testFallbackHosts(): void
    {
        when('home_url')->justReturn($this->current);
        $this->assertSame(parse_hosts($this->current), (new CacheBustScripts())->validHosts());
    }

    public function testLocal(): void
    {
        $this->functions();
        $bust = new CacheBustScripts($this->current);

        $this->assertSame(
            'https://domain.com/file.aa8f289ebe.js?a=b&ver=1.5&c=d',
            $bust->src('https://domain.com/file.js?a=b&ver=1.5&c=d')
        );

        $this->assertSame(
            '//domain.com/file.aa8f289ebe.css?a=b&ver=1.5',
            $bust->src('//domain.com/file.css?a=b&ver=1.5'),
            'Protocol relative'
        );

        $this->assertSame(
            $src = 'https://domain.com/file.js',
            $bust->src($src),
            'Without query'
        );

        $this->assertSame(
            $src = 'https://domain.com/file.js?a=b',
            $bust->src($src),
            'Without version'
        );
    }

    public function testLocalWithoutVersion(): void
    {
        $this->functions();
        $bust = new CacheBustScripts($this->current);
        $this->assertSame($src = 'https://domain.com/file.js?a=b&c=d', $bust->src($src));
    }

    public function testExternal(): void
    {
        $this->functions();
        $bust = new CacheBustScripts($this->current);
        $this->assertSame($src = 'https://google.com/fonts.css', $bust->src($src));
    }

    public function testLength(): void
    {
        $this->functions();
        $bust = (new CacheBustScripts($this->current))->setHashLength(5);

        $this->assertSame(
            'http://domain.com/file.aa8f2.css?ver=1.5',
            $bust->src('http://domain.com/file.css?ver=1.5')
        );
    }

    public function testBadSrc(): void
    {
        $this->functions();
        $bust = new CacheBustScripts($this->current);
        $this->assertSame($src = '//', $bust->src($src));
    }

    protected function functions(): void
    {
        when('remove_query_arg')->returnArg(2);
    }
}
