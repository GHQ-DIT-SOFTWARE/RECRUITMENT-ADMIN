<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Phases;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Medical;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ApiMedicalsController extends Controller
{
    public function applicant_medicals(Request $request)
    {
        $query = Applicant::with(['regions', 'branches'])->whereHas('medicals_phase');
        // Exact match for sex
        if ($request->has('sex') && in_array($request->input('sex'), ['MALE', 'FEMALE'])) {
            $query->where('sex', '=', $request->input('sex'));
        }
        // Partial match for surname
        if ($request->has('surname') && $request->input('surname') != '') {
            $query->where('surname', 'LIKE', '%' . $request->input('surname') . '%');
        }
        // Partial match for other names
        if ($request->has('other_names') && $request->input('other_names') != '') {
            $query->where('other_names', 'LIKE', '%' . $request->input('other_names') . '%');
        }
        // Exact match for commission type
        if ($request->has('commission_type') && $request->input('commission_type') != '') {
            $query->where('commission_type', '=', $request->input('commission_type'));
        }
        // Exact match for arm of service
        if ($request->has('arm_of_service') && $request->input('arm_of_service') != '') {
            $query->where('arm_of_service', '=', $request->input('arm_of_service'));
        }
        // Exact match for branch
        if ($request->has('branch') && $request->input('branch') != '') {
            $query->where('branch', '=', $request->input('branch'));
        }
        // Exact match for region
        if ($request->has('region') && $request->input('region') != '') {
            $query->where('region', '=', $request->input('region'));
        }
        // Exact match for qualification
        if ($request->has('qualification') && $request->input('qualification') != '') {
            $query->where('qualification', '=', $request->input('qualification'));
        }
        // Partial match for applicant serial number
        if ($request->has('applicant_serial_number') && $request->input('applicant_serial_number') != '') {
            $query->where('applicant_serial_number', 'LIKE', '%' . $request->input('applicant_serial_number') . '%');
        }
        return DataTables::of($query)
            ->addColumn('region_name', function ($applicant) {
                return $applicant->regions ? $applicant->regions->region_name : 'N/A';
            })
            ->addColumn('branch_name', function ($applicant) {
                return $applicant->branches ? $applicant->branches->branch : 'N/A';
            })
            ->addColumn('action', function ($row) {
                // Generate URL for Applicant bodyselec status using Applicant's uuid
                $statusUrl = route('test.medical-status', ['uuid' => $row->uuid]);
                // Fetch the related bodyselec record using applicant_id
                $appmediclas = Medical::where('applicant_id', $row->id)->first();
                // Generate URL for updating bodyselec status using the bodyselec's uuid
                $statusUpdateUrl = $appmediclas
                ? route('test.medical-status-update', ['uuid' => $appmediclas->uuid])
                : '#'; // Fallback if no bodyselec exists
                $action = '<div class="btn-group" role="group">';
                // Add the link for viewing status
                $action .= '<a href="' . $statusUrl . '" class="btn btn-info btn-sm has-ripple"><i class="feather icon-edit"></i>&nbsp;medicals<span class="ripple ripple-animate"></span></a>';

                // Add the link for updating bodyselec status (only if bodyselec exists)
                if ($appmediclas) {
                    $action .= '<a href="' . $statusUpdateUrl . '" class="btn btn-success btn-sm"><i class="feather icon-edit"></i>&nbsp;Update</a>';
                } else {
                    $action .= '<a href="#" class="btn btn-secondary btn-sm disabled" title="Not Available"><i class="feather icon-edit"></i>&nbsp;Update</a>';
                }

                $action .= '</div>'; // End the button group
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

    // public function master_medicals_applicant(Request $request)
    // {
    //     $query = Medical::with(['applicant', 'applicant.regions', 'applicant.branches']);

    //     // Filter by status (QUALIFIED or DISQUALIFIED)
    //     if ($request->has('medical_status') && in_array($request->input('medical_status'), ['QUALIFIED', 'DISQUALIFIED'])) {
    //         $query->where('medical_status', '=', $request->input('medical_status'));
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
    //         ->addColumn('surname', function ($medicals) {
    //             return $medicals->applicant->surname ?? 'N/A';
    //         })
    //         ->addColumn('other_names', function ($medicals) {
    //             return $medicals->applicant->other_names ?? 'N/A';
    //         })
    //         ->addColumn('sex', function ($medicals) {
    //             return $medicals->applicant->sex ?? 'N/A';
    //         })
    //         ->addColumn('commission_type', function ($medicals) {
    //             return $medicals->applicant->commission_type ?? 'N/A';
    //         })
    //         ->addColumn('arm_of_service', function ($medicals) {
    //             return $medicals->applicant->arm_of_service ?? 'N/A';
    //         })
    //         ->addColumn('contact', function ($medicals) {
    //             return $medicals->applicant->contact ?? 'N/A';
    //         })
    //         ->addColumn('region_name', function ($medicals) {
    //             return $medicals->applicant->regions->region_name ?? 'N/A';
    //         })
    //         ->addColumn('branch_name', function ($medicals) {
    //             return $medicals->applicant->branches->branch ?? 'N/A';
    //         })
    //         ->addColumn('applicant_serial_number', function ($medicals) {
    //             return $medicals->applicant->applicant_serial_number ?? 'N/A';
    //         })
    //         ->addColumn('action', function ($medicals) {
    //             $statusUpdateUrl = $medicals ? route('test.medical-status-update', ['uuid' => $medicals->uuid]) : '#';
    //             $action = '<div class="btn-group" role="group">';
    //             if ($medicals) {
    //                 $action .= '<a href="' . $statusUpdateUrl . '" class="btn btn-success btn-sm"><i class="feather icon-edit"></i>&nbsp;Update Status</a>';
    //             } else {
    //                 $action .= '<a href="#" class="btn btn-secondary btn-sm disabled" title="Not Available"><i class="feather icon-edit"></i>&nbsp;Update Not Yet</a>';
    //             }

    //             $action .= '</div>';
    //             return $action;
    //         })
    //         ->editColumn('medical_status', function ($medicals) {
    //             switch ($medicals->medical_status) {
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
    //         ->rawColumns(['action', 'medical_status'])
    //         ->make(true);
    // }

    public function master_medicals_applicant(Request $request)
    {
        $query = Medical::with(['applicant', 'applicant.regions', 'applicant.branches']);

        // Combine all filtering criteria into a single query
        if ($request->has('medical_status') && in_array($request->input('medical_status'), ['QUALIFIED', 'DISQUALIFIED'])) {
            $query->where('medical_status', '=', $request->input('medical_status'));
        }

        $filters = [
            'sex' => ['MALE', 'FEMALE'],
            'surname' => null,
            'other_names' => null,
            'commission_type' => null,
            'arm_of_service' => null,
            'branch' => null,
            'region' => null,
            'applicant_serial_number' => null,
        ];

        foreach ($filters as $key => $validValues) {
            if ($request->has($key) && ($validValues === null || in_array($request->input($key), $validValues))) {
                $query->whereHas('applicant', function ($q) use ($key, $request) {
                    if ($key === 'surname' || $key === 'other_names' || $key === 'applicant_serial_number') {
                        $q->where($key, 'LIKE', '%' . $request->input($key) . '%');
                    } else {
                        $q->where($key, '=', $request->input($key));
                    }
                });
            }
        }

        return DataTables::of($query)
            ->addColumn('surname', function ($medicals) {
                return $medicals->applicant->surname ?? 'N/A';
            })
            ->addColumn('other_names', function ($medicals) {
                return $medicals->applicant->other_names ?? 'N/A';
            })
            ->addColumn('sex', function ($medicals) {
                return $medicals->applicant->sex ?? 'N/A';
            })
            ->addColumn('commission_type', function ($medicals) {
                return $medicals->applicant->commission_type ?? 'N/A';
            })
            ->addColumn('arm_of_service', function ($medicals) {
                return $medicals->applicant->arm_of_service ?? 'N/A';
            })
            ->addColumn('contact', function ($medicals) {
                return $medicals->applicant->contact ?? 'N/A';
            })
            ->addColumn('region_name', function ($medicals) {
                return $medicals->applicant->regions->region_name ?? 'N/A';
            })
            ->addColumn('branch_name', function ($medicals) {
                return $medicals->applicant->branches->branch ?? 'N/A';
            })
            ->addColumn('applicant_serial_number', function ($medicals) {
                return $medicals->applicant->applicant_serial_number ?? 'N/A';
            })
            ->addColumn('action', function ($medicals) {
                $statusUpdateUrl = $medicals ? route('test.medical-status-update', ['uuid' => $medicals->uuid]) : '#';
                $action = '<div class="btn-group" role="group">';
                if ($medicals) {
                    $action .= '<a href="' . $statusUpdateUrl . '" class="btn btn-success btn-sm"><i class="feather icon-edit"></i>&nbsp;Update Status</a>';
                } else {
                    $action .= '<a href="#" class="btn btn-secondary btn-sm disabled" title="Not Available"><i class="feather icon-edit"></i>&nbsp;Update Not Yet</a>';
                }

                $action .= '</div>';
                return $action;
            })
            ->editColumn('medical_status', function ($medicals) {
                switch ($medicals->medical_status) {
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
            ->rawColumns(['action', 'medical_status'])
            ->make(true);
    }
}
