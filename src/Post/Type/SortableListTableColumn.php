<?php

declare(strict_types=1);

namespace Fire\Post\Type;

use Fire\Admin\ListTableColumn;
use WP_Query;

abstract class SortableListTableColumn extends ListTableColumn
{
    public function sort(WP_Query $query): void
    {
        $query->set('meta_key', $this->key());
        $query->set('orderby', 'meta_value');
    }
}
