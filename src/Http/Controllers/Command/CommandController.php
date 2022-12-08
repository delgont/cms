<?php

namespace Delgont\Cms\Http\Controllers\Command;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Artisan;



class CommandController extends Controller
{
   public function index()
   {
    $output = '';
    return view('delgont::commands.index', compact('output'));
   }

   public function run(Request $request)
   {
        $run = Artisan::call($request->command);
        return $output = Artisan::output();
        return back()->withInput();
   }
}
