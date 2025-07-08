<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subsubbranch;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\SubBranch;
use Yajra\DataTables\DataTables;

class SubSubBranchController extends Controller
{
    public function index(Request $request)
    {
        $query = Subsubbranch::with(['main_branch','sub_branch'])->latest()->get();

        $result = DataTables::of($query)
            ->addColumn('branch_name', function ($record) {
                return $record->main_branch ? $record->main_branch->branch : 'N/A';
            })
              ->addColumn('sub_branch_name', function ($record) {
                return $record->sub_branch ? $record->sub_branch->sub_branch : 'N/A';
            })
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
        return view('admin.pages.subsubbranch.index');
    }
    public function getSubBranches($branch_id)
    {
        $subBranches = SubBranch::where('branch_id', $branch_id)->get(['id', 'sub_branch']);
        return response()->json($subBranches);
    }
    public function Add()
    {
        $branch = Branch::get();
        return view('admin.pages.subsubbranch.create', compact('branch'));
    }

    public function Store(Request $request)
    {
        $request->validate([
            'sub_sub_branch' => 'required',
        ]);
        Subsubbranch::create([
            'sub_sub_branch' => $request->sub_sub_branch,
            'branch_id' => $request->branch_id,
            'sub_branch_id' => $request->sub_branch_id,
        ]);
        $notification = [
            'message' => 'Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('branch-sub-sub-index')->with($notification);
    }

    public function Edit($uuid)
    {
        $branch = Subsubbranch::where('uuid', $uuid)->first();
        if (!$branch) {
            abort(404);
        }
        return view('admin.pages.subsubbranch.edit', compact('branch'));
    }

    public function Update(Request $request, $uuid)
    {
        $branch = Subsubbranch::where('uuid', $uuid)->first();
        if (!$branch) {
            abort(404);
        }
        $branch->branch = $request->branch;
        $branch->save();
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('branch-sub-sub-index')->with($notification);
    }

    public function Delete($uuid)
    {
        $branch = Subsubbranch::where('uuid', $uuid)->first();
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
