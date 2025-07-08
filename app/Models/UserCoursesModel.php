<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\SaveToUpper;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class UserCoursesModel extends Model
{
    use HasFactory;
     use UuidTrait;
     use SaveToUpper;


    protected $table = 'user_courses';

    protected $fillable = [
        'course_id',
        'user_id',
        'level',
        'semester',
        'lecturer_id',
        'category_id',
        'remarks'
    ];


    // public function category()
    // {
    //     return $this->belongsTo(CategoryModel::class, 'category_id', 'id');
    // }


    public function getCategoryNamesAttribute()
    {
        // Ensure category_id is an array
        if (!is_array($this->category_id)) {
            return [];
        }

        // Query category_name by matching IDs
        return CategoryModel::whereIn('id', $this->category_id)
            ->pluck('category_name')
            ->toArray();
    }



    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }


    public function categories()
    {
        return $this->belongsToMany(CategoryModel::class, 'user_course_category', 'user_course_id', 'category_id');
    }




    public function subject()
    {
        return $this->belongsTo(SubjectsModel::class, 'subject_id', 'id');
    }


    public function lecturers()
{
    return $this->belongsTo(User::class, 'lecturer_id','id');
}



    public function course()
    {
        return $this->belongsTo(OfferingCourse::class, 'course_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Fetch students enrolled in a particular course
    public function students()
    {
        return $this->hasMany(UserCoursesModel::class, 'course_id', 'course_id')
                    ->whereHas('user', function ($query) {
                        $query->where('role', 'Student');
                    });
    }

    // Fetch lecturers assigned to a particular course
    // public function lecturer()
    // {
    //     return $this->hasOne(UserCoursesModel::class, 'course_id', 'course_id')
    //                 ->whereHas('user', function ($query) {
    //                     $query->where('role', 'Lecturer');
    //                 });
    // }

    // Fetch total subjects under a course
    public function subjects()
    {
        return $this->hasMany(UserCoursesModel::class, 'course_id', 'course_id')
                    ->distinct('subject_id');
    }

    public function packages()
    {
        return $this->hasMany(PackagingModel::class, 'course_id', 'course_id');
    }

}







