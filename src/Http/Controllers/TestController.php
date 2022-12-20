<?php

namespace Delgont\Cms\Http\Controllers;

use Delgont\Cms\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Delgont\Cms\Repository\Post\PostRepository;
use Delgont\Cms\Repository\Menu\MenuRepository;

use Delgont\Cms\Cache\Post\PostCacheManager;

use Delgont\Cms\Models\Post\Post;

use Illuminate\Support\Facades\Cache;


class TestController extends Controller
{
    protected $repository = null;
    protected $menuRepo = null;
    protected $post = null;

    public function __construct()
    {
        $this->repository = app(PostRepository::class);
        $this->post = $this->repository->fromCache()->find(1);
        $this->repository->setPost($this->post);

        $this->menuRepo = app(MenuRepository::class);

    }
    public function index()
    {
        return $this->menuRepo->menuItems('main_menu');
        
        $template =  $this->repository->children();
        return $template;
    }
}
