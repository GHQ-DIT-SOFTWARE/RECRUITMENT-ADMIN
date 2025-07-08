<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{

    // public function applicant_reports_table(Request $request)
    // {
    //     $query = Applicant::latest()->where('qualification','QUALIFIED');
    //     if ($request->has('sex') && in_array($request->input('sex'), ['MALE', 'FEMALE'])) {
    //         $query->where('sex', 'LIKE', '%' . $request->input('sex'));
    //     }

    //     if ($request->has('surname')) {
    //         $query->where('surname', 'LIKE', '%' . $request->input('surname') . '%');
    //     }
    //     if ($request->has('other_names')) {
    //         $query->where('other_names', 'LIKE', '%' . $request->input('other_names') . '%');
    //     }
    //     if ($request->has('cause_offers')) {
    //         $query->where('cause_offers', 'LIKE', '%' . $request->input('cause_offers') . '%');
    //     }

    //     if ($request->has('qualification')) {
    //         $query->where('qualification', 'LIKE', '%' . $request->input('qualification') . '%');
    //     }
    //     if ($request->has('applicant_serial_number')) {
    //         $query->where('applicant_serial_number', 'LIKE', '%' . $request->input('applicant_serial_number') . '%');
    //     }

    //     return DataTables::of($query)
    //         ->addColumn('action', function ($row) {
    //             $pdfUrl = route('correct.correction-applicant-data', ['uuid' => $row->uuid]);
    //             $beceUrl = asset($row->bece_certificate);
    //             $wassceUrl = asset($row->wassce_certificate);

    //             return '<a href="' . $pdfUrl . '" class="btn btn-primary btn-sm" ">Applicant Info(PDF)</a>
    //                    ';
    //         })
    //         ->editColumn('qualification', function ($record) {
    //             switch ($record->qualification) {
    //                 case 'DISQUALIFIED':
    //                     return '<span class="badge badge-danger">DISQUALIFIED</span>';
    //                 case 'QUALIFIED':
    //                     return '<span class="badge badge-success">QUALIFIED</span>';
    //                 default:
    //                     return '';
    //             }
    //         })
    //         ->rawColumns(['action', 'qualification'])
    //         ->make(true);
    // }

    public function applicant_reports_table(Request $request)
    {
        $query = Applicant::query()->latest()->where('qualification', 'QUALIFIED')
            ->whereDoesntHave('resultVerification', function ($query) {
                $query->whereNotNull('result_verified');
            });
        if ($request->has('search_query') && $request->input('search_query') != '') {
            $searchQuery = $request->input('search_query');
            // Search across multiple columns
            $query->where(function ($q) use ($searchQuery) {
                $q->where('surname', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('first_name', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('other_names', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('entrance_type', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('applicant_serial_number', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('cause_offers', 'LIKE', '%' . $searchQuery . '%');
            });
        }
        // if ($request->has('sex') && in_array($request->input('sex'), ['MALE', 'FEMALE'])) {
        //     $query->where('sex', 'LIKE', '%' . $request->input('sex'));
        // }

        // if ($request->has('surname')) {
        //     $query->where('surname', 'LIKE', '%' . $request->input('surname') . '%');
        // }

        // if ($request->has('other_names')) {
        //     $query->where('other_names', 'LIKE', '%' . $request->input('other_names') . '%');
        // }

        // if ($request->has('cause_offers')) {
        //     $query->where('cause_offers', 'LIKE', '%' . $request->input('cause_offers') . '%');
        // }
        // if ($request->has('entrance_type')) {
        //     $query->where('entrance_type', 'LIKE', '%' . $request->input('entrance_type') . '%');
        // }

        // if ($request->has('qualification')) {
        //     $query->where('qualification', 'LIKE', '%' . $request->input('qualification') . '%');
        // }

        // if ($request->has('applicant_serial_number')) {
        //     $query->where('applicant_serial_number', 'LIKE', '%' . $request->input('applicant_serial_number') . '%');
        // }

        return DataTables::of($query)
            ->addColumn('action', function ($row) {
                $pdfUrl = route('correct.correction-applicant-data', ['uuid' => $row->uuid]);
                return '<a href="' . $pdfUrl . '" class="btn btn-primary btn-sm">View</a>';
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
            ->rawColumns(['action', 'qualification'])
            ->make(true);
    }
}
