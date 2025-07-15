<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UuidTrait;
use App\Models\Traits\SaveToUpper;

class InitialDocumentation extends Model
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
        'applicant_id' => 'unsignedBigInteger',
        'initial_documentation_status' => 'string',
        'initial_documentation_marks' => 'text',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];
}
