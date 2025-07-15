<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AgeLimit;

use Illuminate\Http\Request;

class AgeLimitController extends Controller
{
    public function index()
    {
        $agelimit = AgeLimit::latest()->get();
        return view('admin.pages.agelimit.index', compact('agelimit'));
    }

    public function Add()
    {

        return view('admin.pages.agelimit.create');
    }

    public function Store(Request $request)
    {
        $request->validate([
            'agelimit_date' => 'required',
            'trade_type' => 'required',
        ]);
        AgeLimit::create([
            'trade_type' => $request->trade_type,
            'agelimit_date' => $request->agelimit_date,
        ]);
        $notification = [
            'message' => 'Created Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('set.agelimit-index')->with($notification);
    }

    public function Edit($uuid)
    {
        $agelimit = AgeLimit::where('uuid', $uuid)->first();
        if (!$agelimit) {
            abort(404);
        }
        return view('admin.pages.agelimit.edit', compact('agelimit'));
    }

    public function Update(Request $request, $uuid)
    {
        $agelimit = AgeLimit::where('uuid', $uuid)->first();
        if (!$agelimit) {
            abort(404);
        }
        $agelimit->agelimit_date = $request->agelimit_date;
        $agelimit->save();
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('set.agelimit-index')->with($notification);
    }
    public function Delete($uuid)
    {
        $agelimit = AgeLimit::where('uuid', $uuid)->first();
        if (!$agelimit) {
            abort(404);
        }
        $agelimit->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
