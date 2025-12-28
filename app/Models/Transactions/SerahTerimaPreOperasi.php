<?php

namespace App\Models\Transactions;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerahTerimaPreOperasi extends Model
{
    use HasFactory, LogsActivity;
    protected $guarded = ['id'];
    protected $hidden = ['updated_at', 'created_at'];
    protected $casts = [
        'kesadaran' => 'array',
        'riwayat_alergi_obat' => 'array',
        'persiapan_operasi' => 'array',
        'alat_kesehatan' => 'array',
        'jenis_darah' => 'array',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'noreg', 'noreg');
    }
}
