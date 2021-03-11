<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UF extends Model
{
    use HasFactory;

    protected $table = "ufs";

    protected $fillable = [
      'nome',
      'sigla',
      'regiao_id',
        'codigo_ibge',
    ];

    public function regiao(){
        return $this->belongsTo(Regiao::class, 'regiao_id');
    }
}
