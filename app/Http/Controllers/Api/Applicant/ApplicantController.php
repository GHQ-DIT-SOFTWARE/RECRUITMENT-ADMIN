<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Applicant;

class ApplicantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Applicant::query();
        return Datatables::of($data)
            ->addColumn('action', function ($row) {
                $action = '';
                $action .= '<div class="btn-group"> <button type="button" class="btn btn-outline-dark btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options</button><div class="dropdown-menu bg-light" style="">';
                $action .= '<a class="dropdown-item btn-edit" href="javascript:void(0)" data-href="' . route('step.applicant.show', $row->uuid) . '">Edit</a>';
                $action .= '<a class="dropdown-item text-danger btn-delete" href="javascript:void(0)" data-href="' . route('step.applicant.destroy', $row->uuid) . '">Delete</a>';
                $action .= '</div></div>';
                return $action ?? '...';
            })
            ->rawColumns(['action', 'numeral'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
