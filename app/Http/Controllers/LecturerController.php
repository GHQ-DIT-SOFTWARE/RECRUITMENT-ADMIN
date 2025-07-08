<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserCoursesModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\PackagingModel;
use App\Models\Student;
use App\Models\CategoryModel;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;
use App\Models\OfferingCourse;

class LecturerController extends Controller
{
    public function lecturer_dashboard()
    {
        $user = auth()->user();
        $lecturerID = auth()->id();

        $assignedCourses = UserCoursesModel::with('course')
            ->where('lecturer_id', $lecturerID)
            ->get()
            ->map(function ($item) {
                $categoryIds = is_array($item->category_id)
                    ? $item->category_id
                    : json_decode($item->category_id, true);

                if (!is_array($categoryIds)) {
                    $categoryIds = [];
                }

                $students = Student::where('course_id', $item->course_id)->get();

                $filteredStudents = $students->filter(function ($student) use ($item, $categoryIds) {
                    return PackagingModel::where('course_id', $student->course_id)
                        ->where('level', $item->level)
                        ->whereIn('category_id', $categoryIds)
                        ->exists();
                });

                $item->course_name = $item->course->cause_offers ?? 'N/A';
                $item->students = $filteredStudents->values();
                $item->total_students = $filteredStudents->count();

                return (object) $item;
            });

        $groupedCourses = $assignedCourses
            ->groupBy(function ($item) {
                return $item->course_id . '_' . $item->level;
            })
            ->map(function ($group) {
                $first = $group->first();
                $mergedStudents = $group->flatMap(function ($item) {
                    return $item->students;
                });

                // ✅ Remove duplicate students by user_id
                $uniqueStudents = $mergedStudents->unique('user_id')->values();

                return (object)[
                    'course_id' => $first->course_id,
                    'course_name' => $first->course_name,
                    'level' => $first->level,
                    'students' => $uniqueStudents,
                    'total_students' => $uniqueStudents->count(),
                ];
            })
            ->values();

        return view('admin.pages.Lecturer.dashboard', [
            'user' => $user,
            'assignedCourses' => $groupedCourses
        ]);
    }

    public function downloadStudents($courseId, $level)
    {
        $course = DB::table('courses')->where('id', $courseId)->first();

        $filename = $course ? $course->course_code . "_Level_{$level}_Students.xlsx" : "students.xlsx";

        return Excel::download(new StudentsExport($courseId, $level), $filename);
    }

    public function viewStudentsForLecturerSubject($courseId, $level)
    {
        $lecturerID = auth()->id();

        $lecturerSubjects = UserCoursesModel::where('lecturer_id', $lecturerID)
            ->where('course_id', $courseId)
            ->where('level', $level)
            ->pluck('category_id')
            ->map(function ($item) {
                return is_array($item) ? $item : json_decode($item, true);
            })
            ->flatten()
            ->unique()
            ->toArray();

        $studentIds = PackagingModel::where('course_id', $courseId)
            ->where('level', $level)
            ->whereIn('category_id', $lecturerSubjects)
            ->pluck('user_id')
            ->unique()
            ->toArray();

        $students = Student::whereIn('user_id', $studentIds)->get();

        return view('admin.pages.Lecturer.students', compact('students'));
    }

    public function students_results(Request $request)
    {
        $lecturerID = Auth::id();

        $courseIds = UserCoursesModel::where('lecturer_id', $lecturerID)
            ->pluck('course_id')
            ->toArray();

        $rawCategories = UserCoursesModel::where('lecturer_id', $lecturerID)
            ->pluck('category_id')
            ->toArray();

        $categoryIds = collect($rawCategories)
            ->flatMap(function ($item) {
                $decoded = json_decode($item, true);
                return is_array($decoded) ? $decoded : [$item];
            })
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $query = DB::table('students')
            ->join('users', 'students.email', '=', 'users.email')
            ->leftJoin('packaging', 'students.course_id', '=', 'packaging.course_id')
            ->leftJoin('category', 'packaging.category_id', '=', 'category.id')
            ->whereIn('students.course_id', $courseIds)
            ->whereIn('packaging.category_id', $categoryIds);

        if ($request->has('search_query') && !empty($request->search_query)) {
            $query->where('packaging.level', $request->search_query);
        }

        $students = $query->select(
        'students.id as student_id',
        'students.index_number',
        'students.surname',
        'students.first_name',
        'students.other_names',
        'students.sex',
        'students.email',
        DB::raw("CONCAT(students.surname, ' ', students.first_name, ' ', COALESCE(students.other_names, '')) as student_name"),
        'category.category_name as subject_name',
        'packaging.level',
        'packaging.semester'
    )
    ->get()
    ->unique(fn($item) => $item->index_number . '_' . $item->level . '_' . $item->semester)
    ->values()
    ->groupBy(['level', 'semester']);


        $courses = DB::table('offering_courses')
            ->whereIn('id', $courseIds)
            ->select('id', 'cause_offers')
            ->get();

        return view('admin.pages.Lecturer.student_results', compact('students', 'courses'));
    }
}
