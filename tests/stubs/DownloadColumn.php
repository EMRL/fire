<?php

declare(strict_types=1);

use Fire\Admin\ListTableColumn;

final class DownloadColumn extends ListTableColumn
{
    protected string $key = 'download';

    protected string $label = 'Download';

    public function display(int $id): void
    {
        echo "id:$id";
    }
}
