<?php

declare(strict_types=1);

namespace Fire\Tests\Post\Type;

use Fire\Post\Type\Query;
use Fire\Tests\TestCase;

final class QueryTest extends TestCase
{
    public function testQuery(): void
    {
        $query = $this->wpQuery();

        $query->shouldReceive('set')
            ->once()
            ->with('key', 'value');

        (new Query(['key' => 'value']))($query);
    }
}
