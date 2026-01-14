<?php

namespace App\Models\Transactions;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanAnastesi extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];
    protected $hidden = ['updated_at', 'created_at'];

    protected $casts = [
        'klasifikasi_asa'          => 'array',
        'posisi_pasien'            => 'array',
        'premedikasi'              => 'array',
        'induksi'                  => 'array',
        'tata_laksana_jalan_napas' => 'array',
        'intubasi'                 => 'array',
        'ventilasi'                => 'array',
        'regional_anestesi'        => 'array',
        'monitoring_anestesi'      => 'array',
    ];
}
