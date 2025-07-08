<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\School;

use App\Http\Controllers\Controller;
use App\Models\WASSCERESULTS;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class WassceResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function View()
    {
        $wassce = WASSCERESULTS::latest()->get();
        return view('admin.pages.wassceresults.index', compact('wassce'));
    }

    public function Add()
    {
        return view('admin.pages.wassceresults.create');
    }

    public function Store(Request $request)
    {
        $request->validate([
            'wassceresult' => ['required', Rule::unique('w_a_s_s_c_e_r_e_s_u_l_t_s')],
        ]);
        WASSCERESULTS::create([
            'wassceresult' => $request->wassceresult,
        ]);
        $notification = [
            'message' => 'wassce Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('results.wassce-results-index')->with($notification);
    }

    public function Edit($uuid)
    {
        $wassce = WASSCERESULTS::where('uuid', $uuid)->first();
        if (!$wassce) {
            abort(404);
        }
        return view('admin.pages.wassceresults.edit', compact('wassce'));
    }

    public function Update(Request $request)
    {
        $wassce_id = $request->uuid;
        $wassce = WASSCERESULTS::where('uuid', $wassce_id)->first();
        if (!$wassce) {
            abort(404);
        }
        $wassce->update([
            'beceresults' => $request->beceresults,
            'updated_at' => Carbon::now(),
        ]);
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('results.wassce-results-index')->with($notification);
    }

    public function Delete($uuid)
    {
        $wassce = WASSCERESULTS::where('uuid', $uuid)->first();
        if (!$wassce) {
            abort(404);
        }
        $wassce->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
