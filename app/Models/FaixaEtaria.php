<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaixaEtaria extends Model
{
    use HasFactory;

    protected $table = 'faixa_etarias';

    protected $fillable = [
        'classe',
        'idade_min',
        'idade_max',
    ];

    public function pessoa(){
        return $this->hasMany(Paciente::class, 'faixa_etaria_id');
    }
}
