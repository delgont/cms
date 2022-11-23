<?php

namespace Delgont\Cms\Http\Controllers\Account;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use Delgont\Cms\Models\Activity\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activitylog = auth()->user()->activitylog()->orderBy('created_at', 'desc')->paginate(4);
        return (request()->expectsJson()) ? response()->json(['activitylog' => $activitylog]) :  view('delgont::account.activitylog.index', compact(['activitylog']));
    }

    public function destroy($id)
    {
        ActivityLog::destroy($id);
        return back();
    }
}
