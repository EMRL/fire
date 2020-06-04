<?php

declare(strict_types=1);

use Fire\Post\Type\SortableListTableColumn;

final class SortableDownloadColumn extends SortableListTableColumn
{
    protected string $key = 'download';

    protected string $label = 'Download';
}
