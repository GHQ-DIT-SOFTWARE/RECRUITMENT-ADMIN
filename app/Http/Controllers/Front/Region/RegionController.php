<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\Region;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class RegionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function View()
    {
        $region = Region::latest()->get();
        return view('admin.pages.regions.index', compact('region'));
    }

    public function AddCate()
    {
        return view('admin.pages.regions.create');
    }

    public function Store(Request $request)
    {
        $request->validate([
            'region_name' => ['required', Rule::unique('regions')],
        ]);
        Region::create([
            'region_name' => $request->region_name,
        ]);
        $notification = [
            'message' => 'Region Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('view-index')->with($notification);
    }

    public function Edit($uuid)
    {
        $region = Region::where('uuid', $uuid)->first();
        if (!$region) {
            abort(404);
        }

        return view('admin.pages.regions.edit', compact('region'));
    }

    public function Update(Request $request)
    {
        $region_id = $request->uuid;
        $region = Region::where('uuid', $region_id)->first();
        if (!$region) {
            abort(404);
        }
        $region->update([
            'region_name' => $request->region_name,
            'updated_at' => Carbon::now(),
        ]);
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('view-index')->with($notification);
    }

    public function Delete($uuid)
    {
        $region = Region::where('uuid', $uuid)->first();
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
