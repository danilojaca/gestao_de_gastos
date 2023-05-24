<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestaoGasto extends Model
{
    use HasFactory;
    //protected $table = 'gestao_gastos';
    protected $fillable = [
        'mes_id',
        'gastos',
        'valores',
        'pago',
        'ano',
        
    ];
    public function Mes(){

        return $this->belongsTo('App\Models\Mes');
     }
    
}
