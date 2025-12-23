<?php

namespace App\Models\Transactions;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengkajianPreAnastesi extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $guarded = ['id'];
    protected $casts = [
        'anamnesis' => 'array',
        'pemeriksaan_fisik_umum' => 'array',
        'pemeriksaan_jalan_napas' => 'array',
    ];
}
