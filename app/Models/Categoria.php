<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:d/m/Y - H:i:s',
    ];
    protected $fillable = [
        'nome'
    ];
}
