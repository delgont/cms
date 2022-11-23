<?php

namespace Delgont\Cms\Http\Controllers\System;

use Delgont\Cms\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Delgont\Cms\Models\Group\Group;



class SystemSettingController extends Controller
{
    public function index()
    {
        return Group::where('group_key', 'system_settings')->with(['options'])->first();
    }
}
