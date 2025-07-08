<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentsModel extends Model
{
    //
    protected $table = 'assignments';

    protected $fillable = [
        'user_id',
        'course_id',
        'category_id',
        'subject_id',
        'assignment_id',
        'assignment_name',
        'assignment_pdf',
        'assignment_remarks'
    ];

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(SubjectsModel::class, 'subject_id', 'id');
    }

    public function courses()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
