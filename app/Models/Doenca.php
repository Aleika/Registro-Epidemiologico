<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Doenca extends Model
{
    use HasFactory;

    protected $table = 'doencas';

    protected $fillable = [
        'nome', 'descricao',
    ];

    public function pacientes(){
        return $this->belongsToMany(Paciente::class, 'paciente_doencas');
    }
}
