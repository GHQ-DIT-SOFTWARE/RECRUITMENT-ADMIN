<?php
declare(strict_types=1);
namespace App\Http\Controllers\Api\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Yajra\DataTables\DataTables;

class ApiTrialFeesController extends Controller
{
      public function students_payments(Request $request)
    {
        $query = Payment::whereHas('interview_phase', function ($q) {
            $q->whereNull('interview_status'); // Show only applicants where interview_status is NULL
        });
        // Search functionality for multiple fields
        if ($request->has('search_query') && $request->input('search_query') != '') {
            $searchQuery = $request->input('search_query');
            $query->where(function ($q) use ($searchQuery) {
                $q->where('surname', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('other_names', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('applicant_serial_number', 'LIKE', '%' . $searchQuery . '%');
            });
        }
        // Exact match for sex
        if ($request->has('sex') && in_array($request->input('sex'), ['MALE', 'FEMALE'])) {
            $query->where('sex', '=', $request->input('sex'));
        }

        // Exact match for qualification
        if ($request->has('qualification') && $request->input('qualification') != '') {
            $query->where('qualification', '=', $request->input('qualification'));
        }

        return DataTables::of($query->get())
            ->addColumn('checkbox', function ($record) {
                return '<div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input approve-checkbox"
                                data-record-id="' . $record->id . '"
                                id="approve-checkbox-' . $record->id . '">
                            <label class="custom-control-label"
                                for="approve-checkbox-' . $record->id . '"> </label>
                        </div>';
            })
            ->editColumn('qualification', function ($record) {
                switch ($record->qualification) {
                    case 'DISQUALIFIED':
                        return '<span class="badge badge-danger">DISQUALIFIED</span>';
                    case 'PENDING':
                        return '<span class="badge badge-warning">PENDING</span>';
                    case 'QUALIFIED':
                        return '<span class="badge badge-success">QUALIFIED</span>';
                    default:
                        return '';
                }
            })
            ->rawColumns(['checkbox', 'qualification'])
            ->make(true);
    }

}
