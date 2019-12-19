<?php

declare(strict_types=1);

namespace Fire\Tests\Term\Taxonomy;

use Fire\Term\Taxonomy\RegisterForType;
use Fire\Tests\TestCase;

use function Brain\Monkey\Functions\expect;

final class RegisterForTypeTest extends TestCase
{
    public function testRegisterForType(): void
    {
        $taxonomy = 'cat';
        $type = 'post';

        expect('register_taxonomy_for_object_type')
            ->once()
            ->with($taxonomy, $type);

        (new RegisterForType($taxonomy, $type))();
    }
}
