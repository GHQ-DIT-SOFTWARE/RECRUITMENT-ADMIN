<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Phases;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Aptitude;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ApiAptitudeController extends Controller
{

    public function applicant_aptitude_test(Request $request)
    {
        // $query = Applicant::whereHas('aptitude_phase');
        $query = Applicant::whereHas('aptitude_phase', function ($q) {
            $q->whereNull('aptitude_marks')->orWhereNull('aptitude_status');
        });
        // Single search query handling
        if ($request->has('search_query') && $request->input('search_query') != '') {
            $searchQuery = $request->input('search_query');
            $query->where(function ($q) use ($searchQuery) {
                $q->where('surname', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('other_names', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('applicant_serial_number', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('sex', 'LIKE', '%' . $searchQuery . '%');
            });
        }

        if ($request->has('qualification') && $request->input('qualification') != '') {
            $query->where('qualification', '=', $request->input('qualification'));
        }

        return DataTables::of($query)
            ->addColumn('action', function ($row) {
                // Generate URL for Applicant aptitude status using Applicant's uuid
                $statusUrl = route('test.aptitude-test-status', ['uuid' => $row->uuid]);
                // Fetch the related Documentation record using applicant_id
                $aptitude = Aptitude::where('applicant_id', $row->id)->first();
                // Generate URL for updating aptitude status using the aptitude's uuid
                $statusUpdateUrl = $aptitude
                    ? route('test.aptitude-test-status-update', ['uuid' => $aptitude->uuid])
                    : '#'; // Fallback if no aptitude exists
                $action = '<div class="btn-group" role="group">';
                // Add the link for viewing status
                $action .= '<a href="' . $statusUrl . '" class="btn btn-info btn-sm has-ripple"><i class="feather icon-edit"></i>&nbsp;aptitude<span class="ripple ripple-animate"></span></a>';
                // Add the link for updating aptitude status (only if aptitude exists)
                if ($aptitude) {
                    $action .= '<a href="' . $statusUpdateUrl . '" class="btn btn-success btn-sm"><i class="feather icon-edit"></i>&nbsp;Update aptitude</a>';
                } else {
                    $action .= '<a href="#" class="btn btn-secondary btn-sm disabled" title="No aptitude Available"><i class="feather icon-edit"></i>&nbsp;Update aptitude</a>';
                }

                $action .= '</div>'; // End the button group
                return $action;
            })
            ->editColumn('qualification', function ($record) {
                switch ($record->qualification) {
                    case 'DISQUALIFIED':
                        return '<span class="badge badge-danger">DISQUALIFIED</span>';
                    case 'PENDING':
                        return '<span class="badge badge-danger">PENDING</span>';
                    case 'QUALIFIED':
                        return '<span class="badge badge-success">QUALIFIED</span>';
                    default:
                        return '';
                }
            })
            ->rawColumns(['action', 'qualification'])
            ->make(true);
    }

    public function master_aptitude_applicant(Request $request)
    {
        $query = Aptitude::with('applicant')->whereNull('notified_at');
        // Define filterable fields and their corresponding request keys
        $filters = [
            'aptitude_status' => 'aptitude_status',
            'sex' => 'sex',
            'surname' => 'surname',
            'other_names' => 'other_names',
            'applicant_serial_number' => 'applicant_serial_number',
        ];

        // Loop through filters and apply them to the query
        foreach ($filters as $dbField => $requestKey) {
            if ($request->has($requestKey) && $request->input($requestKey) != '') {
                if (in_array($requestKey, ['aptitude_status', 'sex'])) {
                    $query->whereHas('applicant', function ($q) use ($request, $requestKey) {
                        $q->where($requestKey, '=', $request->input($requestKey));
                    });
                } else {
                    $query->whereHas('applicant', function ($q) use ($request, $requestKey) {
                        $q->where($requestKey, 'LIKE', '%' . $request->input($requestKey) . '%');
                    });
                }
            }
        }

        return DataTables::of($query)
            ->addColumn('surname', fn($aptitude) => $aptitude->applicant->surname ?? 'N/A')
            ->addColumn('other_names', fn($aptitude) => $aptitude->applicant->other_names ?? 'N/A')
            ->addColumn('first_name', fn($aptitude) => $aptitude->applicant->first_name ?? 'N/A')
            ->addColumn('sex', fn($aptitude) => $aptitude->applicant->sex ?? 'N/A')
            ->addColumn('contact', fn($aptitude) => $aptitude->applicant->contact ?? 'N/A')
            ->addColumn('applicant_serial_number', fn($aptitude) => $aptitude->applicant->applicant_serial_number ?? 'N/A')
            ->addColumn('action', function ($aptitude) {
                $statusUpdateUrl = route('test.aptitude-test-status-update', ['uuid' => $aptitude->uuid]);
                $action = '<div class="btn-group" role="group">';
                $action .= $aptitude ?
                    '<a href="' . $statusUpdateUrl . '"class="btn btn-sm text-white" style="background-color: #adb5bd;""><i class="feather icon-edit"></i>&nbsp;Update Status</a>' :
                    '<a href="#" class="btn btn-secondary btn-sm disabled" title="Not Available"><i class="feather icon-edit"></i>&nbsp;Update Not Yet</a>';
                $action .= '</div>';
                return $action;
            })
            ->editColumn('aptitude_status', function ($aptitude) {
                switch ($aptitude->aptitude_status) {
                    case 'DISQUALIFIED':
                        return '<span class="badge badge-danger">DISQUALIFIED</span>';
                    case 'PENDING':
                        return '<span class="badge badge-warning">PENDING</span>';
                    case 'QUALIFIED':
                        return '<span class="badge text-white" style="background-color: #adb5bd;">QUALIFIED</span>';
                    default:
                        return '';
                }
            })
            ->rawColumns(['action', 'aptitude_status'])
            ->make(true);
    }
}
