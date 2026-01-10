<?php

namespace App\Models\Transactions;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScorePascaAnastesi extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];
    protected $hidden = ['updated_at', 'created_at'];
    protected $casts = [
        'aldrete_score' => 'array',
        'bromage_score' => 'array',
        'steward_score' => 'array',
    ];
}
