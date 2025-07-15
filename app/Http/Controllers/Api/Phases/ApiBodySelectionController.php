<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Phases;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\BodySelection;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ApiBodySelectionController extends Controller
{

    // public function applicant_body_selection_table(Request $request)
    // {
    //     // Fetch applicants who have a related BodySelection record
    //     $query = Applicant::with(['regions', 'branches'])->whereHas('bodySelection_phase');
    //     // Exact match for sex
    //     if ($request->has('sex') && in_array($request->input('sex'), ['MALE', 'FEMALE'])) {
    //         $query->where('sex', '=', $request->input('sex'));
    //     }

    //     // Partial match for surname
    //     if ($request->has('surname') && $request->input('surname') != '') {
    //         $query->where('surname', 'LIKE', '%' . $request->input('surname') . '%');
    //     }

    //     // Partial match for other names
    //     if ($request->has('other_names') && $request->input('other_names') != '') {
    //         $query->where('other_names', 'LIKE', '%' . $request->input('other_names') . '%');
    //     }

    //     // Exact match for commission type
    //     if ($request->has('commission_type') && $request->input('commission_type') != '') {
    //         $query->where('commission_type', '=', $request->input('commission_type'));
    //     }

    //     // Exact match for arm of service
    //     if ($request->has('arm_of_service') && $request->input('arm_of_service') != '') {
    //         $query->where('arm_of_service', '=', $request->input('arm_of_service'));
    //     }

    //     // Exact match for branch
    //     if ($request->has('branch') && $request->input('branch') != '') {
    //         $query->where('branch', '=', $request->input('branch'));
    //     }

    //     // Exact match for region
    //     if ($request->has('region') && $request->input('region') != '') {
    //         $query->where('region', '=', $request->input('region'));
    //     }

    //     // Exact match for qualification
    //     if ($request->has('qualification') && $request->input('qualification') != '') {
    //         $query->where('qualification', '=', $request->input('qualification'));
    //     }

    //     // Partial match for applicant serial number
    //     if ($request->has('applicant_serial_number') && $request->input('applicant_serial_number') != '') {
    //         $query->where('applicant_serial_number', 'LIKE', '%' . $request->input('applicant_serial_number') . '%');
    //     }

    //     // Process the query using DataTables
    //     return DataTables::of($query)
    //         ->addColumn('region_name', function ($applicant) {
    //             return $applicant->regions ? $applicant->regions->region_name : 'N/A';
    //         })
    //         ->addColumn('branch_name', function ($applicant) {
    //             return $applicant->branches ? $applicant->branches->branch : 'N/A';
    //         })
    //         ->addColumn('action', function ($row) {
    //             // Generate URL for viewing bodySelection status using Applicant's uuid
    //             $statusUrl = route('bodyselection.body-selection-status', ['uuid' => $row->uuid]);

    //             // Fetch the related BodySelection record using applicant_id
    //             $bodySelection = BodySelection::where('applicant_id', $row->id)->first();

    //             // Generate URL for updating bodySelection status using the bodySelection's uuid
    //             $statusUpdateUrl = $bodySelection
    //             ? route('bodyselection.body-selection-status-update', ['uuid' => $bodySelection->uuid])
    //             : '#'; // Fallback if no bodySelection exists

    //             $action = '<div class="btn-group" role="group">';

    //             // Add the link for viewing status
    //             $action .= '<a href="' . $statusUrl . '" class="btn btn-info btn-sm"><i class="feather icon-edit"></i>&nbsp;Body Selection</a>';
    //             // Add the link for updating bodySelection status (only if bodySelection exists)
    //             if ($bodySelection) {
    //                 $action .= '<a href="' . $statusUpdateUrl . '" class="btn btn-success btn-sm"><i class="feather icon-edit"></i>&nbsp;Update Body Selection</a>';
    //             } else {
    //                 $action .= '<a href="#" class="btn btn-secondary btn-sm disabled" title="Not Available"><i class="feather icon-edit"></i>&nbsp;Update Body Selection</a>';
    //             }
    //             $action .= '</div>'; // End the button group
    //             return $action;
    //         })
    //         ->editColumn('qualification', function ($record) {
    //             switch ($record->qualification) {
    //                 case 'DISQUALIFIED':
    //                     return '<span class="badge badge-danger">DISQUALIFIED</span>';
    //                 case 'PENDING':
    //                     return '<span class="badge badge-warning">PENDING</span>';
    //                 case 'QUALIFIED':
    //                     return '<span class="badge badge-success">QUALIFIED</span>';
    //                 default:
    //                     return '';
    //             }
    //         })
    //         ->rawColumns(['action', 'qualification'])
    //         ->make(true);
    // }

    public function applicant_body_selection_table(Request $request)
    {
        // Fetch applicants who have a related BodySelection record
        $query = Applicant::with(['regions', 'branches'])->whereHas('bodySelection_phase');
        // General search handling
        if ($request->has('search_query') && $request->input('search_query') != '') {
            $searchTerm = $request->input('search_query');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('surname', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('applicant_serial_number', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('commission_type', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('arm_of_service', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('qualification', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Exact match for sex
        if ($request->has('sex') && in_array($request->input('sex'), ['MALE', 'FEMALE'])) {
            $query->where('sex', '=', $request->input('sex'));
        }

        // Exact match for branch
        if ($request->has('branch') && $request->input('branch') != '') {
            $query->where('branch', '=', $request->input('branch'));
        }

        // Exact match for region
        if ($request->has('region') && $request->input('region') != '') {
            $query->where('region', '=', $request->input('region'));
        }

        // Process the query using DataTables
        return DataTables::of($query)
            ->addColumn('region_name', function ($applicant) {
                return $applicant->regions ? $applicant->regions->region_name : 'N/A';
            })
            ->addColumn('branch_name', function ($applicant) {
                return $applicant->branches ? $applicant->branches->branch : 'N/A';
            })
            ->addColumn('action', function ($row) {
                // Generate URLs for viewing and updating body selection status
                $statusUrl = route('bodyselection.body-selection-status', ['uuid' => $row->uuid]);
                $bodySelection = BodySelection::where('applicant_id', $row->id)->first();
                $statusUpdateUrl = $bodySelection
                ? route('bodyselection.body-selection-status-update', ['uuid' => $bodySelection->uuid])
                : '#'; // Fallback if no bodySelection exists

                // Build action buttons
                $action = '<div class="btn-group" role="group">';
                $action .= '<a href="' . $statusUrl . '" class="btn btn-info btn-sm"><i class="feather icon-edit"></i>&nbsp;Body Selection</a>';
                if ($bodySelection) {
                    $action .= '<a href="' . $statusUpdateUrl . '" class="btn btn-success btn-sm"><i class="feather icon-edit"></i>&nbsp;Update Body Selection</a>';
                } else {
                    $action .= '<a href="#" class="btn btn-secondary btn-sm disabled" title="Not Available"><i class="feather icon-edit"></i>&nbsp;Update Body Selection</a>';
                }
                $action .= '</div>'; // End button group
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

    // public function master_bodyselection_applicant(Request $request)
    // {
    //     $query = BodySelection::with(['applicant', 'applicant.regions', 'applicant.branches']);
    //     // Filter by vetting status (QUALIFIED or DISQUALIFIED)
    //     if ($request->has('body_selection_status') && in_array($request->input('body_selection_status'), ['QUALIFIED', 'DISQUALIFIED'])) {
    //         $query->where('body_selection_status', '=', $request->input('body_selection_status'));
    //     }

    //     // Filter by applicant's sex
    //     if ($request->has('sex') && in_array($request->input('sex'), ['MALE', 'FEMALE'])) {
    //         $query->whereHas('applicant', function ($q) use ($request) {
    //             $q->where('sex', '=', $request->input('sex'));
    //         });
    //     }

    //     // Filter by applicant's surname
    //     if ($request->has('surname') && $request->input('surname') != '') {
    //         $query->whereHas('applicant', function ($q) use ($request) {
    //             $q->where('surname', 'LIKE', '%' . $request->input('surname') . '%');
    //         });
    //     }

    //     // Filter by applicant's other names
    //     if ($request->has('other_names') && $request->input('other_names') != '') {
    //         $query->whereHas('applicant', function ($q) use ($request) {
    //             $q->where('other_names', 'LIKE', '%' . $request->input('other_names') . '%');
    //         });
    //     }

    //     // Filter by applicant's commission type
    //     if ($request->has('commission_type') && $request->input('commission_type') != '') {
    //         $query->whereHas('applicant', function ($q) use ($request) {
    //             $q->where('commission_type', '=', $request->input('commission_type'));
    //         });
    //     }

    //     // Filter by applicant's arm of service
    //     if ($request->has('arm_of_service') && $request->input('arm_of_service') != '') {
    //         $query->whereHas('applicant', function ($q) use ($request) {
    //             $q->where('arm_of_service', '=', $request->input('arm_of_service'));
    //         });
    //     }

    //     // Filter by applicant's branch
    //     if ($request->has('branch') && $request->input('branch') != '') {
    //         $query->whereHas('applicant', function ($q) use ($request) {
    //             $q->where('branch', '=', $request->input('branch'));
    //         });
    //     }

    //     // Filter by applicant's region
    //     if ($request->has('region') && $request->input('region') != '') {
    //         $query->whereHas('applicant', function ($q) use ($request) {
    //             $q->where('region', '=', $request->input('region'));
    //         });
    //     }

    //     // Filter by applicant's serial number
    //     if ($request->has('applicant_serial_number') && $request->input('applicant_serial_number') != '') {
    //         $query->whereHas('applicant', function ($q) use ($request) {
    //             $q->where('applicant_serial_number', 'LIKE', '%' . $request->input('applicant_serial_number') . '%');
    //         });
    //     }

    //     return DataTables::of($query)
    //         ->addColumn('surname', function ($bodyselection) {
    //             return $bodyselection->applicant->surname ?? 'N/A';
    //         })
    //         ->addColumn('other_names', function ($bodyselection) {
    //             return $bodyselection->applicant->other_names ?? 'N/A';
    //         })
    //         ->addColumn('sex', function ($bodyselection) {
    //             return $bodyselection->applicant->sex ?? 'N/A';
    //         })
    //         ->addColumn('commission_type', function ($bodyselection) {
    //             return $bodyselection->applicant->commission_type ?? 'N/A';
    //         })
    //         ->addColumn('arm_of_service', function ($bodyselection) {
    //             return $bodyselection->applicant->arm_of_service ?? 'N/A';
    //         })
    //         ->addColumn('contact', function ($bodyselection) {
    //             return $bodyselection->applicant->contact ?? 'N/A';
    //         })
    //         ->addColumn('region_name', function ($bodyselection) {
    //             return $bodyselection->applicant->regions->region_name ?? 'N/A';
    //         })
    //         ->addColumn('branch_name', function ($bodyselection) {
    //             return $bodyselection->applicant->branches->branch ?? 'N/A';
    //         })
    //         ->addColumn('applicant_serial_number', function ($bodyselection) {
    //             return $bodyselection->applicant->applicant_serial_number ?? 'N/A';
    //         })
    //         ->addColumn('action', function ($bodyselection) {
    //             $statusUpdateUrl = $bodyselection ? route('bodyselection.body-selection-status-update', ['uuid' => $bodyselection->uuid]) : '#';
    //             $action = '<div class="btn-group" role="group">';
    //             if ($bodyselection) {
    //                 $action .= '<a href="' . $statusUpdateUrl . '" class="btn btn-success btn-sm"><i class="feather icon-edit"></i>&nbsp;Update Status</a>';
    //             } else {
    //                 $action .= '<a href="#" class="btn btn-secondary btn-sm disabled" title="Not Available"><i class="feather icon-edit"></i>&nbsp;Update Not Yet</a>';
    //             }

    //             $action .= '</div>';
    //             return $action;
    //         })
    //         ->editColumn('body_selection_status', function ($bodyselection) {
    //             switch ($bodyselection->body_selection_status) {
    //                 case 'DISQUALIFIED':
    //                     return '<span class="badge badge-danger">DISQUALIFIED</span>';
    //                 case 'QUALIFIED':
    //                     return '<span class="badge badge-success">QUALIFIED</span>';
    //                 default:
    //                     return '';
    //             }
    //         })
    //         ->rawColumns(['action', 'body_selection_status'])
    //         ->make(true);
    // }

    public function master_bodyselection_applicant(Request $request)
    {
        $query = BodySelection::with(['applicant', 'applicant.regions', 'applicant.branches']);
        // General search handling
        if ($request->has('search_query') && $request->input('search_query') != '') {
            $searchTerm = $request->input('search_query');
            $query->whereHas('applicant', function ($q) use ($searchTerm) {
                $q->where('surname', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('other_names', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('applicant_serial_number', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('commission_type', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('arm_of_service', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('branch', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('region', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        // Filter by body selection status (QUALIFIED or DISQUALIFIED)
        if ($request->has('body_selection_status') && in_array($request->input('body_selection_status'), ['QUALIFIED', 'DISQUALIFIED'])) {
            $query->where('body_selection_status', '=', $request->input('body_selection_status'));
        }

        // Filter by applicant's sex
        if ($request->has('sex') && in_array($request->input('sex'), ['MALE', 'FEMALE'])) {
            $query->whereHas('applicant', function ($q) use ($request) {
                $q->where('sex', '=', $request->input('sex'));
            });
        }
        return DataTables::of($query)
            ->addColumn('surname', function ($bodyselection) {
                return $bodyselection->applicant->surname ?? 'N/A';
            })
            ->addColumn('other_names', function ($bodyselection) {
                return $bodyselection->applicant->other_names ?? 'N/A';
            })
            ->addColumn('sex', function ($bodyselection) {
                return $bodyselection->applicant->sex ?? 'N/A';
            })
            ->addColumn('commission_type', function ($bodyselection) {
                return $bodyselection->applicant->commission_type ?? 'N/A';
            })
            ->addColumn('arm_of_service', function ($bodyselection) {
                return $bodyselection->applicant->arm_of_service ?? 'N/A';
            })
            ->addColumn('contact', function ($bodyselection) {
                return $bodyselection->applicant->contact ?? 'N/A';
            })
            ->addColumn('region_name', function ($bodyselection) {
                return $bodyselection->applicant->regions->region_name ?? 'N/A';
            })
            ->addColumn('branch_name', function ($bodyselection) {
                return $bodyselection->applicant->branches->branch ?? 'N/A';
            })
            ->addColumn('applicant_serial_number', function ($bodyselection) {
                return $bodyselection->applicant->applicant_serial_number ?? 'N/A';
            })
            ->addColumn('action', function ($bodyselection) {
                $statusUpdateUrl = $bodyselection ? route('bodyselection.body-selection-status-update', ['uuid' => $bodyselection->uuid]) : '#';
                $action = '<div class="btn-group" role="group">';
                if ($bodyselection) {
                    $action .= '<a href="' . $statusUpdateUrl . '" class="btn btn-success btn-sm"><i class="feather icon-edit"></i>&nbsp;Update Status</a>';
                } else {
                    $action .= '<a href="#" class="btn btn-secondary btn-sm disabled" title="Not Available"><i class="feather icon-edit"></i>&nbsp;Update Not Yet</a>';
                }
                $action .= '</div>';
                return $action;
            })
            ->editColumn('body_selection_status', function ($bodyselection) {
                switch ($bodyselection->body_selection_status) {
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
            ->rawColumns(['action', 'body_selection_status'])
            ->make(true);
    }
}
