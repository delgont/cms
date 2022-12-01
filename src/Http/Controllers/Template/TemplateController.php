<?php

namespace Delgont\Cms\Http\Controllers\Template;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Delgont\Cms\Models\Category\Category;

use Delgont\Cms\Models\Template\Template;



use Delgont\Cms\Services\Template\TemplateService;

class TemplateController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $templates = app(Template::class)::with(['categories', 'icon', 'groups'])->withCount(['posts', 'sections'])->paginate(6);
        return (request()->expectsJson()) ? response()->json($templates) : view('delgont::templates.index', compact(['templates']));
    }

    public function show($id)
    {
        $template = app(Template::class)::with([
            'options'
        ])->findOrFail($id);
        return (request()->expectsJson()) ? response()->json($template) : view('delgont::templates.show', compact(['template']));
    }

}