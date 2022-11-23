<?php

namespace Stephendevs\Pagman\Http\Controllers\Settings;

use Stephendevs\Pagman\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Stephendevs\Lad\Traits\UpdatesOrCreatesOptions;



class SettingsController extends Controller
{
    use UpdatesOrCreatesOptions { 
        updateOrCreate as store;
     }

    public function __construct()
    {

    }
   
    public function index()
    {
        $options =  $this->getOptions();
        return view('delgont::settings.index', compact(['options']));
    }

    protected function options() : array 
    {
        return [
            'posts_pagination_count' => 6,
            'use_ckeditor_cdn' => 0
        ];
    }

    protected function rules()
    {
        return [
            'posts_pagination_count' => 'nullable',
            'use_ckeditor_cdn' => 'nullable'
        ];
    }

    
}