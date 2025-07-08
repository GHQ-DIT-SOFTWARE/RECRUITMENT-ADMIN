<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UuidTrait;
use App\Models\Traits\SaveToUpper;

class Subsubbranch extends Model
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
        'branch_id',
        'sub_branch_id',
        'sub_sub_branch',
    ];
 public function main_branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
     public function sub_branch()
    {
        return $this->belongsTo(SubBranch::class, 'sub_branch_id', 'id');
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];
}
