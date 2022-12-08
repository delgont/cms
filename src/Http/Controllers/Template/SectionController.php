<?php

namespace Delgont\Cms\Http\Controllers\Template;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use Delgont\Cms\Models\Section\Section;
use Delgont\Cms\Models\Post\Post;
use Delgont\Cms\Models\Post\PostType;
use Delgont\Cms\Models\Category\Category;
use Delgont\Cms\Models\Group\Group;
use Delgont\Cms\Models\Option\ModelOption;





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
        $groups = app(Group::class)->where('type', Post::class)->get();
        $categories = app(Category::class)->where('type', Post::class)->get(['id','name']);
        $postTYpes = app(PostType::class)->get();
        return (request()->expectsJson()) ? response()->json($templates) : view('delgont::templates.sections.show', compact(['section', 'groups','categories', 'postTYpes']));

    }


    /**
     * Updates or creates section options
     * 
     * @param Illuminate\Http\Request $request
     * @param int $id
     */
    public function updateSettings(Request $request, $id)
    {
        $section = Section::findOrFail($id);
        ModelOption::whereModelType(Section::class)->whereModelId($section->id)->delete();

        if($request->has('type'))
        {
            ModelOption::create([
                'model_type' => Section::class,
                'model_id' => $section->id,
                'key' => 'posts_of_type',
                'value' => json_encode($request->type),
                'cast' => 'array'
            ]);
        }

        if ($request->has('category')) {
            # code...
            ModelOption::create([
                'model_type' => Section::class,
                'model_id' => $section->id,
                'key' => 'posts_of_category',
                'value' => json_encode($request->category),
                'cast' => 'array'
            ]);
        }
        
        return back();
    }

}