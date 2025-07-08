<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\Region;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class DistrictController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = District::with(['regions_districts']);
        $result = DataTables::of($query)
            ->addColumn('action', function ($record) {
                return '<a class="btn btn-primary btn-sm" href="' . route('edit-districts', $record->uuid) . '"><i class="feather icon-edit"></i></a>
                    <a class="btn btn-danger btn-sm" href="' . route('delete-districts', $record->uuid) . '" title="Delete Data" id="delete"><i class="feather icon-trash-2"></i></a>';
            })
            ->make(true);
        return $result;
    }

    public function View()
    {
        return view('admin.pages.regions_district.index');
    }

    public function Add()
    {
        $districts = Region::all();
        return view('admin.pages.regions_district.create', compact('districts'));
    }

    public function Store(Request $request)
    {
        $request->validate([
            'district_name' => ['required', Rule::unique('districts')],
            'region_id' => 'required',
        ]);
        District::create([
            'district_name' => $request->district_name,
            'region_id' => $request->region_id,
            'created_at' => Carbon::now(),
        ]);
        $notification = [
            'message' => 'Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('view-districts')->with($notification);
    }

    public function Edit($uuid)
    {
        $districts = District::where('uuid', $uuid)->first();
        if (!$districts) {
            abort(404);
        }
        $region = Region::all();
        return view('admin.pages.regions_district.edit', compact('districts', 'region'));
    }

    public function Update(Request $request, $uuid)
    {
        $districts = District::where('uuid', $uuid)->first();
        if (!$districts) {
            abort(404);
        }
        $districts->district_name = $request->district_name;
        $districts->region_id = $request->region_id;
        $districts->save();
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('view-districts')->with($notification);
    }

    public function Delete($uuid)
    {
        $districts = District::where('uuid', $uuid)->first();
        if (!$districts) {
            abort(404);
        }
        $districts->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
