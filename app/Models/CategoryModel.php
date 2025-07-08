<?php
declare (strict_types = 1);
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryModel extends Model
{
    //
    use HasFactory;
    use UuidTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'category';

    protected $fillable = [
        'user_id',
        'category_id',
        'category_name',
        'credit_hours',
        'level',
        'category_remarks'
    ];

    // public function lecturers(){
    //     return $this->belongsTo(UserCoursesModel::class,'id','category_id');
    // }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

    ];
}
