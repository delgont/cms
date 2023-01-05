<?php
namespace Delgont\Cms\Http\Controllers\Post;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Delgont\Cms\Models\Post\Post;

use Delgont\Cms\Models\Group\Group;


//Repositories
use Delgont\Cms\Repository\Group\GroupRepository;


class PostGroupController extends Controller
{
    protected $groupRepository = null;


    public function __construct()
    {
        $this->groupRepository = app(GroupRepository::class);
    }
    /**
    * Display a listing of the posts by its type.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $groups = $this->groupRepository->paginate(4);
        return (request()->expectsJson()) ? response()->json(['groups' => $groups]) : view('delgont::posts.groups.index', compact(['groups']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:groups,name'
        ]);

        $group = $this->groupRepository->create([
            'name' => $request->name,
            'type' => Post::class
        ]);

        return back()->withInput();
    }

    public function show($id)
    {
        $group = $this->groupRepository->findOrFail($id);
        return $group;
        return (request()->expectsJson()) ? response()->json([$group]) : view('delgont::posts.groups.show', compact(['group']));
    }


    public function destroy($id)
    {
        $group = $this->groupRepository->findOrFail($id);
        $this->groupRepository->delete($group);
        return back()->with('deleted', 'Post Group deleted successfully');
    }
   

}
