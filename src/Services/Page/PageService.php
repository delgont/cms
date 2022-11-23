<?php

namespace Delgont\Cms\Services\Page;

use Delgont\Cms\Models\Page\Page;


class PageService
{

    public function publish($id) : bool
    {
        $done = Page::where('id', $id)->update(['published' => '1']);
        return ($done) ? true : false;
    }

    public function unPublish($id) : bool
    {
        $done = Page::where('id', $id)->update(['published' => '0']);
        return ($done) ? true : false;
    }
    
}
