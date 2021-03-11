<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = 'municipios';

    protected $fillable = [
      'nome', 'uf_id',
    ];

    public function uf()
    {
        return $this->belongsTo(UF::class, 'uf_id');
    }

    public function pessoa()
    {
        return $this->hasOne(Pessoa::class, 'pessoa_id');
    }
}
