<?php

namespace Delgont\Cms\Http\Composers;

use Illuminate\View\View;

use Delgont\Cms\Models\Template\Template;

class TemplatesComposer
{

    public function compose(View $view)
    {
        $view->with('templates', Template::enabled()->get());
    }
}
