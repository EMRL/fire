<?php

declare(strict_types=1);

namespace Fire\Tests\Post;

use Fire\Post\Type;

final class PostStub extends Type
{
    public const TYPE = 'post';

    public function doRegisterArchivePageSetting(): void
    {
        $this->registerArchivePageSetting();
    }
}
