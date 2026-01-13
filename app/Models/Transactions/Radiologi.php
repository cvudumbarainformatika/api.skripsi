<?php

namespace App\Models\Transactions;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Radiologi extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];
    protected $hidden = ['updated_at', 'created_at'];
    protected $appends = ['dokumen_url'];

    public function getDokumenUrlAttribute()
    {
        if (!$this->path) return null;

        // return route('radiologi.dokumen', $this->id);

        return URL::signedRoute('radiologi.dokumen', ['id' => $this->id]);
    }
}
