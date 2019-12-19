<?php

declare(strict_types=1);

namespace Fire\Tests\Term\Taxonomy;

use Fire\Term\Taxonomy\Hooks;
use Fire\Tests\TestCase;
use Mockery;
use WP_Term;

use function Brain\Monkey\Filters\expectApplied;

final class HooksTest extends TestCase
{
    public function testRegisterAddsHooks(): void
    {
        $instance = $this->hooks()->register();
        $this->assertTrue(has_filter('register_taxonomy_args', [$instance, 'registerTaxonomyArgs']));
        $this->assertTrue(has_filter('term_link', [$instance, 'termLink']));
    }

    public function testRegisterTaxonomyArgs(): void
    {
        $args = [];
        $types = ['post'];

        expectApplied('fire/register_taxonomy_args/test')
            ->once()
            ->with($args, $types);

        $this->hooks()->registerTaxonomyArgs($args, 'test', $types);
    }

    public function testTermLink(): void
    {
        $url = 'url';
        $term = $this->term();

        expectApplied('fire/term_link/test')
            ->once()
            ->with($url, $term);

        $this->hooks()->termLink($url, $term, 'test');
    }

    protected function hooks(): Hooks
    {
        return new Hooks();
    }

    protected function term(): WP_Term
    {
        /** @var WP_Term $term */
        $term = Mockery::mock('WP_Term');
        return $term;
    }
}
