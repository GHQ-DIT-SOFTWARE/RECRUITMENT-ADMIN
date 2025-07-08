<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Phases;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\ResultVerification;
use App\Models\Documentation;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ApiDocumentationController extends Controller
{

    public function applicant_documentation_table(Request $request)
    {
        $query = Applicant::where('qualification', 'QUALIFIED');
        // Check if there's a search query
        if ($request->has('search_query') && $request->input('search_query') != '') {
            $searchQuery = $request->input('search_query');
            // Search across multiple columns
            $query->where(function ($q) use ($searchQuery) {
                $q->where('surname', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('other_names', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('applicant_serial_number', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('cause_offers', 'LIKE', '%' . $searchQuery . '%');
            });
        }
        return DataTables::of($query)

            ->addColumn('action', function ($row) {
                // Documentation-related URLs
                $statusUrl = route('document.documentation-status', ['uuid' => $row->uuid]);
                $documentation = ResultVerification::where('applicant_id', $row->id)->first();
                $statusUpdateUrl = $documentation
                    ? route('document.documentation-status-update', ['uuid' => $documentation->uuid])
                    : '#'; // Fallback if no documentation exists

                // Certificate URLs
                $beceUrl = !empty($row->bece_certificate) ? asset($row->bece_certificate) : null;
                $wassceUrl = !empty($row->wassce_certificate) ? asset($row->wassce_certificate) : null;
                // PDF Report URL
                $pdfUrl = route('report.admin-applicant-pdf', ['uuid' => $row->uuid]);

                $action = '<div class="btn-group" role="group">';

                // View Documentation
                $action .= '<a href="' . $statusUrl . '" class="btn btn-info btn-sm">
                                <i class="feather icon-edit"></i>&nbsp;Verification
                            </a>';

                // Update Documentation (if available)
                if ($documentation) {
                    $action .= '<a href="' . $statusUpdateUrl . '" class="btn btn-success btn-sm">
                                    <i class="feather icon-edit"></i>&nbsp;Update Verification
                                </a>';
                } else {
                    $action .= '<a href="#" class="btn btn-secondary btn-sm disabled" title="No Verification Available">
                                    <i class="feather icon-edit"></i>&nbsp;Update Verification
                                </a>';
                }
                $action .= '<a href="' . $pdfUrl . '" class="btn btn-danger btn-sm" target="_blank">
                <i class="feather icon-file"></i>&nbsp;Summary Report
            </a>';
                // BECE Certificate Preview
                if ($beceUrl) {
                    $action .= '<a href="' . $beceUrl . '" class="btn btn-primary btn-sm" target="_blank">
                                    <i class="feather icon-file-text"></i>&nbsp;BECE Cert
                                </a>';
                }
                // WASSCE Certificate Preview
                if ($wassceUrl) {
                    $action .= '<a href="' . $wassceUrl . '" class="btn btn-warning btn-sm" target="_blank">
                                    <i class="feather icon-file-text"></i>&nbsp;WASSCE Cert
                                </a>';
                }
                // PDF Report Button
                $action .= '</div>';
                return $action;
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
            ->rawColumns(['action', 'qualification'])
            ->make(true);
    }


    public function master_documentation_applicant(Request $request)
    {
        $query = ResultVerification::with('applicant')
            ->whereNull('notified_at'); // ✅ Only results with null notified_at

        // Check if the search query exists
        if ($request->has('search_query') && $request->input('search_query') != '') {
            $searchTerm = $request->input('search_query');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('result_verified', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhereHas('applicant', function ($q) use ($searchTerm) {
                        $q->where('surname', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('other_names', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('sex', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('cause_offers', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('applicant_serial_number', 'LIKE', '%' . $searchTerm . '%');
                    });
            });
        }
        return DataTables::of($query)
            ->addColumn('surname', function ($documentation) {
                return $documentation->applicant->surname ?? 'N/A';
            })
            ->addColumn('other_names', function ($documentation) {
                return $documentation->applicant->other_names ?? 'N/A';
            })
            ->addColumn('sex', function ($documentation) {
                return $documentation->applicant->sex ?? 'N/A';
            })
            ->addColumn('cause_offers', function ($documentation) {
                return $documentation->applicant->cause_offers ?? 'N/A';
            })
            ->addColumn('contact', function ($documentation) {
                return $documentation->applicant->contact ?? 'N/A';
            })
            ->addColumn('applicant_serial_number', function ($documentation) {
                return $documentation->applicant->applicant_serial_number ?? 'N/A';
            })
            ->addColumn('action', function ($documentation) {
                $statusUpdateUrl = $documentation ? route('document.documentation-status-update', ['uuid' => $documentation->uuid]) : '#';
                $action = '<div class="btn-group" role="group">';
                if ($documentation) {
                    $action .= '<a href="' . $statusUpdateUrl . '" class="btn btn-sm text-white" style="background-color: #adb5bd;""><i class="feather icon-edit"></i>&nbsp;Update Status</a>';
                } else {
                    $action .= '<a href="#" class="btn btn-secondary btn-sm disabled" title="Not Available"><i class="feather icon-edit"></i>&nbsp;Update Not Yet</a>';
                }
                $action .= '</div>';
                return $action;
            })
            ->editColumn('result_verified', function ($documentation) {
                switch ($documentation->result_verified) {
                    case 'DISQUALIFIED':
                        return '<span class="badge badge-danger">DISQUALIFIED</span>';
                    case 'QUALIFIED':
                        return '<span class="badge text-white" style="background-color: #adb5bd;">QUALIFIED</span>';

                    case 'PENDING':
                        return '<span class="badge badge-warning">PENDING</span>';
                    default:
                        return '';
                }
            })
            ->rawColumns(['action', 'result_verified'])
            ->make(true);
    }
}
