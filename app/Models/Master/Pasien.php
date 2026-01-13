<?php

namespace App\Models\Master;

use App\Traits\LogsActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];
    protected $hidden = ['updated_at', 'created_at'];

    protected $appends = ['usia'];
    public function getUsiaAttribute()
    {
        $dateOfBirth = $this->tgl_lahir;
        $years = Carbon::parse($dateOfBirth)->age;
        $month = Carbon::parse($dateOfBirth)->month;
        $day = Carbon::parse($dateOfBirth)->day;
        return $years . " Tahun, " . $month . " Bulan, " . $day . " Hari";
    }


    // public function agama()
    // {
    //     return $this->belongsTo(Agama::class, 'agama', 'kode');
    // }
}
