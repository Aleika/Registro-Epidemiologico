<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class RegistroPacienteDoencas extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'paciente_doencas';

    protected $fillable = [
      'paciente_id',
      'doenca_id',
      'data_inicio_sintomas' ,
      'local_inicio_sintomas',
      'data_diagnostico',
      'observacoes',
    ];

    public function pacientes(){
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function doencas(){
        return $this->belongsTo(Doenca::class, 'doenca_id');
    }
}
