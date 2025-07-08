<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\LogActivities;

use App\Http\Controllers\Controller;
use App\Models\activityLog;
use Yajra\DataTables\DataTables;

class UserLogActivitiesController extends Controller
{
    public function index()
    {
        $activitylog = activityLog::latest();
        return DataTables::of($activitylog)
            ->make(true);
    }
}
