<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Pesquisador extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pesquisadores';

    protected $fillable = [
        'especialidade',
        'CRM',
        'perfil',
        'pessoa_id',
    ];

    public function pessoa(){
        return $this->belongsTo(Pessoa::class, 'pessoa_id');
    }
}
