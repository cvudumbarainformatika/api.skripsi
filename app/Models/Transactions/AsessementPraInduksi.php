<?php

namespace App\Models\Transactions;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsessementPraInduksi extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];
    protected $hidden = ['updated_at', 'created_at'];
    protected $casts = [
        'ga_array' => 'array',
        // 'ra_array' => 'array',
        // 'obat_anastesi_array' => 'array',
        // 'obat_emergensi_array' => 'array',
    ];
}
