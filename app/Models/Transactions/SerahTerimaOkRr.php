<?php

namespace App\Models\Transactions;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerahTerimaOkRr extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];
    protected $hidden = ['updated_at', 'created_at'];
}
