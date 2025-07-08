<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\SubBranch;
use Yajra\DataTables\DataTables;

class SubBranchController extends Controller
{
    public function index(Request $request)
    {
        $query = SubBranch::with('main_branch')->latest()->get();

        $result = DataTables::of($query)
            ->addColumn('branch_name', function ($record) {
                return $record->main_branch ? $record->main_branch->branch : 'N/A';
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
        return view('admin.pages.SubBranch.index');
    }

    public function Add()
    {
        $branch = Branch::get();
        return view('admin.pages.SubBranch.create', compact('branch'));
    }

    public function Store(Request $request)
    {
        $request->validate([
            'sub_branch' => 'required',
        ]);
        SubBranch::create([
            'sub_branch' => $request->sub_branch,
            'branch_id' => $request->branch_id,
        ]);
        $notification = [
            'message' => 'Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('branch-sub-index')->with($notification);
    }

    public function Edit($uuid)
    {
        $branch = SubBranch::where('uuid', $uuid)->first();
        if (!$branch) {
            abort(404);
        }
        return view('admin.pages.SubBranch.edit', compact('branch'));
    }

    public function Update(Request $request, $uuid)
    {
        $branch = SubBranch::where('uuid', $uuid)->first();
        if (!$branch) {
            abort(404);
        }
        $branch->branch = $request->branch;
        $branch->save();
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('branch-sub-index')->with($notification);
    }

    public function Delete($uuid)
    {
        $branch = SubBranch::where('uuid', $uuid)->first();
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
