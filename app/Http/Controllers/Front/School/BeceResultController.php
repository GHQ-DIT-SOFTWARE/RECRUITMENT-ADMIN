<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\School;

use App\Http\Controllers\Controller;
use App\Models\BECERESULTS;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class BeceResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function View()
    {
        $region = BECERESULTS::latest()->get();
        return view('admin.pages.beceresults.index', compact('region'));
    }

    public function Add()
    {
        return view('admin.pages.beceresults.create');
    }

    public function Store(Request $request)
    {
        $request->validate([
            'beceresults' => ['required', Rule::unique('b_e_c_e_r_e_s_u_l_t_s')],
        ]);
        BECERESULTS::create([
            'beceresults' => $request->beceresults,
        ]);
        $notification = [
            'message' => 'Region Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('results.bece-results-index')->with($notification);
    }

    public function Edit($uuid)
    {
        $region = BECERESULTS::where('uuid', $uuid)->first();
        if (!$region) {
            abort(404);
        }

        return view('admin.pages.beceresults.edit', compact('region'));
    }

    public function Update(Request $request)
    {
        $region_id = $request->uuid;
        $region = BECERESULTS::where('uuid', $region_id)->first();
        if (!$region) {
            abort(404);
        }
        $region->update([
            'beceresults' => $request->beceresults,
            'updated_at' => Carbon::now(),
        ]);
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('results.bece-results-index')->with($notification);
    }

    public function Delete($uuid)
    {
        $region = BECERESULTS::where('uuid', $uuid)->first();
        if (!$region) {
            abort(404);
        }
        $region->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
