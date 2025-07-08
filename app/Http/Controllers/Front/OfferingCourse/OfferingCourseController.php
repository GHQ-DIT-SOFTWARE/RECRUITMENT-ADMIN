<?php

declare (strict_types = 1);

namespace App\Http\Controllers\Front\OfferingCourse;

use App\Http\Controllers\Controller;
use App\Models\OfferingCourse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OfferingCourseController extends Controller
{
    public function index()
    {
        $arms = OfferingCourse::get();
        return view('admin.pages.offeringcourse.index', compact('arms'));
    }

    public function Add()
    {
        return view('admin.pages.offeringcourse.create');
    }

    public function Store(Request $request)
    {
        $request->validate([
            'cause_offers' => ['required', Rule::unique('offering_courses')],
        ]);
        OfferingCourse::create([
            'cause_offers' => $request->cause_offers,
        ]);
        $notification = [
            'message' => 'Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('arm.arm-of-service')->with($notification);
    }

    public function Edit($uuid)
    {
        $arms = OfferingCourse::where('uuid', $uuid)->first();
        if (!$arms) {
            abort(404);
        }
        return view('admin.pages.offeringcourse.edit', compact('arms'));
    }

    public function Update(Request $request, $uuid)
    {
        $arms = OfferingCourse::where('uuid', $uuid)->first();
        if (!$arms) {
            abort(404);
        }
        $arms->cause_offers = $request->cause_offers;
        $arms->save();
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('arm.arm-of-service')->with($notification);
    }
    public function Delete($uuid)
    {
        $arms = OfferingCourse::where('uuid', $uuid)->first();
        if (!$arms) {
            abort(404);
        }
        $arms->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
