<?php

namespace App\Models\Transactions;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Laboratorium extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];
    protected $hidden = ['updated_at', 'created_at'];
    protected $appends = ['dokumen_url'];
    // protected $casts = [
    //     'lainnya' => 'array',
    // ];

    public function getDokumenUrlAttribute()
    {
        if (!$this->path) return null;

        // return url('/api/dokumen/' . $this->id);
        return route('laborat.dokumen', $this->id);
        // return URL::signedRoute('laborat.dokumen', ['id' => $this->id]);
    }
}
