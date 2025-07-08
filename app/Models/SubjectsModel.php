<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectsModel extends Model
{
    //
    protected $table = 'subjects';

    protected $fillable = [
        'index_number',
        'user_id',
        'subject_id',
        'subject_name',
        'subject_remarks',
    ];

    // public function category()
    // {
    //     return $this->belongsTo(CategoryModel::class, 'category_id', 'id');
    // }


}
