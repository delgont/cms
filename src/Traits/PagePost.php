<?php
namespace Stephendevs\Pagman\Traits;

use Stephendevs\Pagman\Models\Post\Post;
use Stephendevs\Pagman\Models\Page\Page;


trait PagePost {

    protected function pageKey()
    {
        return '';
    }

    protected function with()
    {
        return [];
    }

    private function page()
    {
        return Page::page($this->pageKey(), $this->with())->firstOrFail();
    }
}