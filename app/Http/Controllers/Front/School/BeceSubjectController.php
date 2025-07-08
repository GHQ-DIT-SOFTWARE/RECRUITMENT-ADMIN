<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\School;

use App\Http\Controllers\Controller;
use App\Models\BECESUBJECT;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class BeceSubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function View()
    {
        $becesubject = BECESUBJECT::latest()->get();
        return view('admin.pages.becesubjects.index', compact('becesubject'));
    }

    public function Add()
    {
        return view('admin.pages.becesubjects.create');
    }

    public function Store(Request $request)
    {
        $request->validate([
            'becesubjects' => ['required', Rule::unique('b_e_c_e_s_u_b_j_e_c_t_s')],
        ]);
        BECESUBJECT::create([
            'becesubjects' => $request->becesubjects,
        ]);
        $notification = [
            'message' => 'becesubject Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('subject.bece-subject-index')->with($notification);
    }

    public function Edit($uuid)
    {
        $becesubject = BECESUBJECT::where('uuid', $uuid)->first();
        if (!$becesubject) {
            abort(404);
        }
        return view('admin.pages.becesubjects.edit', compact('becesubject'));
    }

    public function Update(Request $request)
    {
        $becesubject_id = $request->uuid;
        $becesubject = BECESUBJECT::where('uuid', $becesubject_id)->first();
        if (!$becesubject) {
            abort(404);
        }
        $becesubject->update([
            'becesubjects' => $request->becesubjects,
            'updated_at' => Carbon::now(),
        ]);
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('subject.bece-subject-index')->with($notification);
    }

    public function Delete($uuid)
    {
        $becesubject = BECESUBJECT::where('uuid', $uuid)->first();
        if (!$becesubject) {
            abort(404);
        }
        $becesubject->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
