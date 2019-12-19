<?php

declare(strict_types=1);

namespace Fire\Tests\Term\Taxonomy;

use Fire\Term\Taxonomy\Register;
use Fire\Tests\TestCase;

use function Brain\Monkey\Functions\expect;
use function Fire\Core\filter_value;

final class RegisterTest extends TestCase
{
    public function testRegister(): void
    {
        $taxonomy = 'cat';
        $types = ['post', 'page'];
        $config = ['label' => 'Category'];

        expect('register_taxonomy')
            ->once()
            ->with($taxonomy, $types, $config);

        (new Register($taxonomy, filter_value($config), ...$types))();
    }
}
