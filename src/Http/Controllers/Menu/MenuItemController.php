<?php

namespace Delgont\Cms\Http\Controllers\Menu;

use Delgont\Cms\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Delgont\Cms\Http\Requests\MenuItemRequest;
use Delgont\Cms\Models\Menu\Menu;
use Delgont\Cms\Models\Menu\MenuItem;
use Delgont\Cms\Models\Post\Post;



class MenuItemController extends Controller
{

    /**
     * Display a listing of all menu menu items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name)
    {
        
    }
  

    /**
     * Show the form for creating menu item.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        return $request;
        $menuitem = new MenuItem();

        $menuitem->label = $request->label;
        $menuitem->sort = $request->sort;
        $menuitem->menuable_id = $request->menuable_id;
        $menuitem->menu_id = $request->menu_id;
        $menuitem->menuable_type = Post::class;
        $menuitem->parent_id = $request->parent_id;

        $menuitem->save();

        return back()->withInput()->with('success', 'Menu Created Successfully');
    }

    /**
     * Display the specified menu and its items.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($menuitem)
    {
         return 'hello';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = Menu::findOrfail($id);
        return view('pagman::menu.edit', compact(['menu']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        


        return back()->withInput()->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MenuItem::destroy($id);
        return back()->with('success', 'Menu Item deleted from menu successfully');
    }

    private function convertPrimaryMenusToNotPrimary($request)
    {
        if($request->has('is_primary')){
            $primaries = Menu::where('is_primary', '1')->get(['id']);
            for ($i=0; $i < count($primaries) ; $i++) { 
                Menu::where('id', $primaries[$i]['id'])->update(['is_primary' => '0']);
            }
        }
    }

    private function convertFooterMenusToNotFooter($request)
    {
        if($request->has('footer')){
            $footers = Menu::where('footer', '1')->get(['id']);
            for ($i=0; $i < count($footers) ; $i++) { 
                Menu::where('id', $footers[$i]['id'])->update(['footer' => '0']);
            }
        }
    }

      /**
     * Display a listing of menus for ajax.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAjax()
    {
        $menus = Menu::all();
        return response()->json(['data' => $menus]);
    }
}
