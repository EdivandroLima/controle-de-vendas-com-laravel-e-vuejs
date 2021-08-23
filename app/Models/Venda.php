<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:d/m/Y - H:i:s',
    ];
    protected $fillable = [
        'cliente',
        'produto_id',
        'quantidade',
        'valor_total',
        'forma_pagamento',
        'observacoes',
        'status',
    ];

    public function produto()
    {
        return $this->belongsTo('App\Models\Produto', 'produto_id', 'id');
    }
}
