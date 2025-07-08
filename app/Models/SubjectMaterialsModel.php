<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectMaterialsModel extends Model
{
    //
    protected $table = 'subject_materials';
    
    protected $fillable = [
        'user_id',
        'course_id',
        'category_id',
        'subject_id',
        'video_path',
        'pdf_path',
        'subject_remarks'

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
        return $this->belongsTo(CoursesModel::class, 'course_id', 'id');
    }
}
