<?php
namespace Stephendevs\Pagman\Traits;

use Stephendevs\Pagman\Models\Post\Post;
use Stephendevs\Pagman\Models\Page\Page;
use Illuminate\Http\Request;


trait WebPageController {

    public function index()
    {
        $page = $this->page();
        return (request()->expectsJson()) ? response()->json(['page' => $page]) : view($this->view(), compact(['page']));
    }

    private function page()
    {
        return ($this->pageKey()) ? Page::page($this->pageKey(), $this->with())->firstOrFail() : abort('404');
    }

    protected function pageKey()
    {
        return 'about';
    }
    protected function view()
    {
        return 'pagman::tests.index';
    }

    protected function with()
    {
        return [];
    }

}