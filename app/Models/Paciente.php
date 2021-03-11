<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pacientes';

    protected $fillable = [
      'pessoa_id', 'faixa_etaria_id'
    ];

    public function pessoa(){
        return $this->belongsTo(Pessoa::class, 'pessoa_id');
    }

    public function doencas(){
        return $this->belongsToMany(Doenca::class, 'paciente_doencas');
    }

    public function faixaEtaria(){
        return $this->belongsTo(FaixaEtaria::class, 'faixa_etaria_id');
    }
}
