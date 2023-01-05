<?php

namespace Delgont\Cms\Http\Controllers;

use Delgont\Cms\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Delgont\Cms\Repository\Post\PostRepository;
use Delgont\Cms\Repository\Menu\MenuRepository;
use Delgont\Cms\Repository\Template\TemplateRepository;

use Delgont\Cms\Repository\Option\OptionRepository;

use Delgont\Cms\Models\Option\Option;
use Delgont\Cms\Models\Post\Post;
use Delgont\Cms\Models\Group\Group;


use Delgont\Cms\Models\Template\Template;
use Illuminate\Support\Facades\Cache;

use Delgont\Cms\Cache\Post\PostCacheManager;




class TestController extends Controller
{
    protected $repository = null;
    protected $menuRepo = null;

    public function __construct()
    {
        $this->repository = app(PostRepository::class)->fromCache();
        //$this->repository = app(PostRepository::class);
        //$this->post = $this->repository->fromCache()->find(3);
        //$this->repository->setPost($this->post);

    }
    public function index()
    {

        $post = $this->repository->findOrFail(37);
        return $this->repository->paginated()->getChildren($post);
    }
}
