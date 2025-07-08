<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\ApplicantPreview;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PreviewApplicantController extends Controller
{

    public function applicant_master_preview_data(Request $request)
    {
        $query = Applicant::with('regions');
        if ($request->has('search_query') && $request->input('search_query') != '') {
            $searchTerm = $request->input('search_query');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('surname', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('other_names', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('applicant_serial_number', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('cause_offers', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('region', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('qualification', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        if ($request->has('sex') && in_array($request->input('sex'), ['MALE', 'FEMALE'])) {
            $query->where('sex', '=', $request->input('sex'));
        }
        return DataTables::of($query)
            ->addColumn('region_name', function ($applicant) {
                return $applicant->regions ? $applicant->regions->region_name : 'N/A';
            })
            ->addColumn('action', function ($row) {
                $pdfUrl = route('report.admin-applicant-pdf', ['uuid' => $row->uuid]);
                $statusUrl = route('correct.correction-applicant-data', ['uuid' => $row->uuid]);
                $deleteUrl = route('report.delete-applicant', ['uuid' => $row->uuid]);
                $action = '<div class="btn-group" role="group">';
                $action = '<a href="' . $pdfUrl . '" class="btn btn-primary btn-sm" target="_blank">Print PDF</a>';
                $action .= '<a href="' . $statusUrl . '" class="btn btn-info btn-sm has-ripple"><i class="feather icon-edit"></i>&nbsp;Edit Data<span class="ripple ripple-animate"></span></a>';
                $action .= ' <a href="' . $deleteUrl . '" class="btn btn-danger btn-sm" id="delete">Delete</a>';
                $action .= '</div>';
                return $action;
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
