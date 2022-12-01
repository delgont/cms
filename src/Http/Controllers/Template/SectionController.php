<?php

namespace Delgont\Cms\Http\Controllers\Template;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Delgont\Cms\Models\Section\Section;



class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::with([
            'categories', 'groups'
        ])->paginate(6);

        return (request()->expectsJson()) ? response()->json($templates) : view('delgont::templates.sections.index', compact(['sections']));
    }

    public function show($id)
    {
        $section = Section::with(['options'])->findOrFail($id);
        return (request()->expectsJson()) ? response()->json($templates) : view('delgont::templates.sections.show', compact(['section']));

    }

}