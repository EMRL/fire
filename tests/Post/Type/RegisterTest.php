<?php

declare(strict_types=1);

namespace Fire\Tests\Post\Type;

use Fire\Post\Type\Register;
use Fire\Tests\TestCase;

use function Brain\Monkey\Functions\expect;
use function Fire\Core\filter_value;

final class RegisterTest extends TestCase
{
    public function testRegister(): void
    {
        $type = 'post';
        $config = ['label' => 'Resource'];

        expect('register_post_type')
            ->once()
            ->with($type, $config);

        (new Register($type, filter_value($config)))();
    }
}
