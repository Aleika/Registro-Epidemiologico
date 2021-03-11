<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pessoa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pessoas';

    protected $fillable = [
        'nome',
        'cpf',
        'data_nascimento',
        'sexo',
        'endereco',
        'profissao',
        'email',
        'telefone',
        'municipio_id',
    ];

    public function pesquisador(){
        return $this->hasOne(Pesquisador::class, 'pessoa_id');
    }

    public function paciente(){
        return $this->hasOne(Paciente::class, 'pessoa_id');
    }

    public function municipio(){
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

}
