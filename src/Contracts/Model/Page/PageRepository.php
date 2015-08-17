<?php

namespace Fire\Contracts\Model\Page;

interface PageRepository
{
    public function pageOfId($id);

    public function pageOfSlug($slug);

    public function find($args = null);
}
