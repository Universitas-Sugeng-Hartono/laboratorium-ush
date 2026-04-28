<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Laboratorium extends Model
{
    use HasFactory;
    protected $table = 'laboratorium';
    protected $fillable = [
        'id',
        'laboratorium',
    ];
}