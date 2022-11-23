<?php

namespace Delgont\Cms\Http\Controllers\Settings;
use Delgont\Cms\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Delgont\Cms\Models\Group\Group;
use Delgont\Cms\Models\Option\Option;



class GeneralSettingsController extends Controller
{
    public function index()
    {
        $settings = Group::where('group_key', 'general')->with(['options'])->firstOr(function(){
            return Group::updateOrCreate([
                'group_key' => 'general',
                'name' => 'General Settings',
                'description' => 'General Settings'
            ]);
        });
        return view('delgont::settings.general.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $group = Group::where('group_key', 'general')->firstOr(function(){
            return Group::updateOrCreate(['group_key' => 'general'],[
                'group_key' => 'general',
                'name' => 'General Settings',
                'description' => 'General Settings'
            ]);
        });

        ($request->has('cache_options') && !is_null($request->cache_options)) ? $group->options()->updateOrCreate(['option_key' => 'cache_options'], [
            'option_key' => 'cache_options',
            'option_value' => $request->cache_options,
        ]): '';

        ($request->has('page_key_mode') && !is_null($request->page_key_mode)) ? $group->options()->updateOrCreate(['option_key' => 'page_key_mode'], [
            'option_key' => 'page_key_mode',
            'option_value' => $request->page_key_mode,
        ]): '';

        ($request->has('associate_page_with_posts') && !is_null($request->associate_page_with_posts)) ? $group->options()->updateOrCreate(['option_key' => 'associate_page_with_posts'], [
            'option_key' => 'associate_page_with_posts',
            'option_value' => $request->associate_page_with_posts,
        ]): '';

        return back()->withInput();
    }

}