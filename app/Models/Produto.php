<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:d/m/Y - H:i:s',
    ];
    protected $fillable= [
        'nome',
        'quantidade',
        'valor',
        'categoria_id',
        'codigo'
    ];

    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria', 'categoria_id', 'id');
    }
}
