<?php

namespace Delgont\Cms\Http\Composers;

use Illuminate\View\View;

use Delgont\Cms\Models\Menu\Menu;

class MenuComposer
{

    public function compose(View $view)
    {
        $view->with('menus', Menu::orderBy('created_at', 'desc')->paginate(30));
    }
}
