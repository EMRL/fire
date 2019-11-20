<?php

declare(strict_types=1);

namespace Fire\Tests\Term\Taxonomy;

use Fire\Term\Taxonomy\Link;
use Fire\Tests\TestCase;
use Mockery;
use WP_Term;

use function Fire\Core\filter_value;

final class LinkTest extends TestCase
{
    public function testAddsFilters(): void
    {
        $instance = (new Link('', $this->emptyFn()))->register();
        $this->assertTrue(has_filter('term_link', [$instance, 'run']));
    }

    public function testLink(): void
    {
        $taxonomy = 'cat';

        $fn = function (string $url, WP_Term $term): string {
            return $url.'-Test-'.$term->taxonomy;
        };

        $this->assertSame(
            'Something-Test-cat',
            (new Link($taxonomy, $fn))->run('Something', $this->term(), $taxonomy)
        );
    }

    public function testDoesNotModifyOtherTypes(): void
    {
        $value = 'Something';

        $term = $this->term();
        $term->taxonomy = 'other';

        $this->assertSame(
            $value,
            (new Link('cat', filter_value('Test')))->run($value, $term, $term->taxonomy)
        );
    }

    protected function term(): WP_Term
    {
        /** @var WP_Term $term */
        $term = Mockery::mock('WP_Term');
        $term->taxonomy = 'cat';
        return $term;
    }
}
