<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;

class Laboratorium extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'laboratorium';
    protected $fillable = [
        'id',
        'laboratorium',
    ];
}