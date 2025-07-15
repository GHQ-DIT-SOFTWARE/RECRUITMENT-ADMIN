<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{


    public function applicant_reports_table(Request $request)
    {
        $query = Applicant::with('branches')->latest()->where('qualification', 'QUALIFIED')
            ->whereDoesntHave('resultVerification', function ($query) {
                $query->whereNotNull('result_verified');
            });
        // if ($request->has('search_query') && $request->input('search_query') != '') {
        //     $searchQuery = $request->input('search_query');
        //     // Search across multiple columns
        //     $query->where(function ($q) use ($searchQuery) {
        //         $q->where('surname', 'LIKE', '%' . $searchQuery . '%')
        //             ->orWhere('first_name', 'LIKE', '%' . $searchQuery . '%')
        //             ->orWhere('other_names', 'LIKE', '%' . $searchQuery . '%')
        //             ->orWhere('trade_type', 'LIKE', '%' . $searchQuery . '%')
        //             ->orWhere('applicant_serial_number', 'LIKE', '%' . $searchQuery . '%');
        //     });
        // }

        if ($request->has('search_query') && $request->input('search_query') != '') {
            $searchQuery = $request->input('search_query');

            $query->where(function ($q) use ($searchQuery) {
                $q->where('surname', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('first_name', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('other_names', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('trade_type', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('applicant_serial_number', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhereHas('branches', function ($subQuery) use ($searchQuery) {
                        $subQuery->where('branch', 'LIKE', '%' . $searchQuery . '%');
                    });
            });
        }


        return DataTables::of($query)
            ->addColumn('action', function ($row) {
                $pdfUrl = route('correct.correction-applicant-data', ['uuid' => $row->uuid]);
                return '<a href="' . $pdfUrl . '" class="btn btn-primary btn-sm">View</a>';
            })
            ->addColumn('branch', function ($row) {
                return $row->branches ? $row->branches->branch : '';
            })


            ->editColumn('qualification', function ($record) {
                switch ($record->qualification) {
                    case 'DISQUALIFIED':
                        return '<span class="badge badge-danger">DISQUALIFIED</span>';
                    case 'QUALIFIED':
                        return '<span class="badge badge-success">QUALIFIED</span>';
                    default:
                        return '';
                }
            })
            ->rawColumns(['action', 'qualification', 'branch'])
            ->make(true);
    }
}
