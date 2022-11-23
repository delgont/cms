<?php

namespace Delgont\Cms\Http\Controllers\Template;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Delgont\Cms\Models\Category\Category;

use Delgont\Cms\Http\Requests\PostRequest;
use Delgont\Cms\Models\Post\PostType;

use Delgont\Cms\Services\Post\PostService;
use Delgont\Cms\Services\Image\ImageUploadService;


use Delgont\Cms\Services\Template\TemplateService;




class TemplateController extends Controller
{
    private $templateService;

    public function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }

    public function index()
    {
        $templates = $this->templateService->all();
        return (request()->expectsJson()) ? response()->json($templates) : view('delgont::templates.index', compact(['templates']));
    }

    public function show($id)
    {
        $template = $this->templateService->show($id);
        return (request()->expectsJson()) ? response()->json($template) : view('delgont::templates.show', compact(['template']));
    }

}