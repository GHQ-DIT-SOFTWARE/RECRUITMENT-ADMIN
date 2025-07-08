<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\LogActivities;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use Yajra\DataTables\DataTables;

class UserAuditTrailActivitiesController extends Controller
{
    public function index()
    {
        // $audittrail = Audit::with('auditrail')->latest();
        // return DataTables::of($audittrail)
        //     ->addColumn('user_name', function ($audit) {
        //         return $audit->auditrail->name ?? '';
        //     })
        //     ->rawColumns(['user_name'])
        //     ->make(true);
        return DataTables::of(Audit::with('auditrail')->latest())
            ->addColumn('user_name', function ($audit) {
                return $audit->auditrail->name ?? '';
            })
            ->rawColumns(['user_name'])
            ->toJson();
    }
}
