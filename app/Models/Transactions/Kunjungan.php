<?php

namespace App\Models\Transactions;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kunjungan extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $guarded = ['id'];
    protected $hidden = ['updated_at', 'created_at'];

    public function pj()
    {
        return $this->belongsTo(PenanggungJawabPasien::class, 'noreg', 'noreg');
    }
    public function sertipreop()
    {
        return $this->belongsTo(SerahTerimaPreOperasi::class, 'noreg', 'noreg');
    }
    public function pengkajian_pre_anastesi()
    {
        return $this->belongsTo(PengkajianPreAnastesi::class, 'noreg', 'noreg');
    }
    public function laboratorium()
    {
        return $this->belongsTo(Laboratorium::class, 'noreg', 'noreg');
    }
    public function radiologi()
    {
        return $this->belongsTo(Radiologi::class, 'noreg', 'noreg');
    }
    public function assasement_pra_anastesi()
    {
        return $this->belongsTo(AssasementPraAnastesi::class, 'noreg', 'noreg');
    }
    public function asessement_pra_induksi()
    {
        return $this->belongsTo(AsessementPraInduksi::class, 'noreg', 'noreg');
    }
    public function check_list_keselamatan_operasi()
    {
        return $this->belongsTo(CheckListKeselamatanOperasi::class, 'noreg', 'noreg');
    }
    public function askan_anastesi()
    {
        return $this->belongsTo(AskanAnastesi::class, 'noreg', 'noreg');
    }
    public function serah_terima_pasca_op()
    {
        return $this->belongsTo(SerahTerimaPascaOperasi::class, 'noreg', 'noreg');
    }
    public function score_pasca_anastesi()
    {
        return $this->belongsTo(ScorePascaAnastesi::class, 'noreg', 'noreg');
    }
}
