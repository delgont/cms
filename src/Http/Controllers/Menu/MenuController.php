<?php

namespace Delgont\Cms\Http\Controllers\Menu;

use Delgont\Cms\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Delgont\Cms\Http\Requests\MenuRequest;

use Delgont\Cms\Models\Menu\Menu;
use Delgont\Cms\Models\Menu\MenuItem;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::whereNull('parent_id')->with('children')->get();
        return (request()->expectsJson()) ? response()->json($menus) : view('delgont::menus.index', compact(['menus']));
    }

    public function show($id)
    {

        $menu = Menu::withOrganisedMenuItems()->findOrFail($id);
        $menuItems = MenuItem::whereMenuId($id)->get();
        return view('delgont::menus.edit', compact(['menu', 'menuItems']));
    }
}
