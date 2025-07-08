<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ArmOfService;
use App\Models\Branch;
use App\Models\CommissionType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        $query = Branch::latest()->get();
        $result = DataTables::of($query)
            ->addColumn('action', function ($record) {
                return '
                <a class="btn btn-info btn-sm" href="' . route('bran.edit-branch', $record->uuid) . '" title="Edit Data" id="edit"><i class="feather icon-edit"></i></a>
                <a class="btn btn-danger btn-sm" href="' . route('bran.delete-branch', $record->uuid) . '" title="Delete Data" id="delete"><i class="feather icon-trash-2"></i></a>';
            })
            ->make(true);
        return $result;
    }
    public function View()
    {
        return view('admin.pages.branch.index');
    }

    public function Add()
    {

        return view('admin.pages.branch.create');
    }

    public function Store(Request $request)
    {
        $request->validate([
            'branch' => 'required',
        ]);
        Branch::create([
            'branch' => $request->branch,
           
            'arm_of_service' => $request->arm_of_service,
        ]);
        $notification = [
            'message' => 'Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('bran.branch-index')->with($notification);
    }

    public function Edit($uuid)
    {
        $branch = Branch::where('uuid', $uuid)->first();
        if (!$branch) {
            abort(404);
        }
        return view('admin.pages.branch.edit', compact('branch'));
    }

    public function Update(Request $request, $uuid)
    {
        $branch = Branch::where('uuid', $uuid)->first();
        if (!$branch) {
            abort(404);
        }
        $branch->branch = $request->branch;
        $branch->save();
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('bran.branch-index')->with($notification);
    }

    public function Delete($uuid)
    {
        $branch = Branch::where('uuid', $uuid)->first();
        if (!$branch) {
            abort(404);
        }
        $branch->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
