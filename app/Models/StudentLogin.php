<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class StudentLogin extends Model
{
    //
    use HasFactory;
    use UuidTrait;

    protected $table = 'student_login';
    protected $fillable = [
        'student_id',
        'index_number',
        'default_password',
        'changed_password',
        'fees',
        'amount_paid',
        'code'
    ];
}
