<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UuidTrait;
use App\Models\Traits\SaveToUpper;

class StudentFee extends Model
{
    use HasFactory;
    use UuidTrait;
    use SaveToUpper;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'level',
        'semester',
        'reference',
        'email',
        'phone',
        'amount',
        'payment_percentage',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];
}
