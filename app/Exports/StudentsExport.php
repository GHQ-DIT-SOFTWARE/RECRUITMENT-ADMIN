<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\PackagingModel;
use App\Models\UserCoursesModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    protected $courseId;
    protected $level;

    public function __construct($courseId, $level)
    {
        $this->courseId = $courseId;
        $this->level = $level;
    }

    public function collection()
    {
        $lecturerId = auth()->id() ?? 1;

        // 1. Get category IDs the lecturer teaches
        $categoryIds = UserCoursesModel::where('lecturer_id', $lecturerId)
            ->where('course_id', $this->courseId)
            ->where('level', $this->level)
            ->pluck('category_id')
            ->flatMap(function ($item) {
                return is_array($item) ? $item : json_decode($item, true);
            })
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        // 2. Get all students for the course
        $students = Student::where('course_id', $this->courseId)->get();

        // 3. Filter based on PackagingModel (just like in controller)
        $filteredStudents = $students->filter(function ($student) use ($categoryIds) {
            return PackagingModel::where('course_id', $student->course_id)
                ->where('level', $this->level)
                ->whereIn('category_id', $categoryIds)
                ->exists();
        })->values();

        return $filteredStudents->map(function ($student) {
            return [
                $student->index_number,
                $student->surname,
                $student->first_name,
                $student->other_names,
                $student->sex,
                $student->contact,
                $student->email,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Index Number',
            'Surname',
            'First Name',
            'Other Names',
            'Sex',
            'Contact',
            'Email',
        ];
    }
}
