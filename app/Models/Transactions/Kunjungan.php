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
}
