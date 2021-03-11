<?php

namespace App\Exports;

use App\Http\Controllers\API\ConsultasController;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ConsultaExport implements FromCollection, WithHeadings
{

    protected $doenca, $doenca_ordem, $uf, $uf_ordem,$municipio, $municipio_ordem, $faixa_etaria, $faixa_etaria_ordem, $sexo, $sexo_ordem;

    function __construct($doenca, $doenca_ordem, $uf, $uf_ordem,$municipio, $municipio_ordem, $faixa_etaria, $faixa_etaria_ordem, $sexo, $sexo_ordem) {
        $this->doenca = $doenca;
        $this->doenca_ordem = $doenca_ordem;
        $this->uf = $uf;
        $this->uf_ordem = $uf_ordem;
        $this->municipio = $municipio;
        $this->municipio_ordem = $municipio_ordem;
        $this->faixa_etaria = $faixa_etaria;
        $this->faixa_etaria_ordem = $faixa_etaria_ordem;
        $this->sexo = $sexo;
        $this->sexo_ordem = $sexo_ordem;
    }

    public function headings():array{
        return [
          'quantidade_pacientes', 'doenca', 'doenca_nome', 'UF', 'nome_uf', 'municipio', 'nome_municipio', 'faixa_etaria', 'idade_min_faixa', 'classe_faixa_etaria', 'sexo'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = $this->select();

        $query = $this->where($query);

        $query = $query . $this->groupBy();

        $query = $this->orderBy($query);

        $result = DB::select( DB::raw($query));

       return collect($result);
    }

    public function select(){
        $query = 'select count(pe.id) as "quantidade_pacientes", d.id as "doenca", d.nome as "nome_doenca", ufs.id as "UF", ufs.nome as "nome_uf", ';
        $query = $query . ' mu.id as "municipio", mu.nome as "nome_municipio", fe.id as "faixa_etaria", fe.idade_min as "idade_minima_da_faixa", ';
        $query = $query . ' fe.classe as "classe_faixa_etaria", pe.sexo as "sexo" ';
        $query = $query . ' from paciente_doencas pd ';
        $query = $query . ' inner join pacientes pa on pa.id = pd.paciente_id ';
        $query = $query . ' inner join doencas d on d.id = pd.doenca_id ';
        $query = $query . ' inner join pessoas pe on pe.id = pa.pessoa_id ';
        $query = $query . ' inner join municipios mu on mu.id = pe.municipio_id ';
        $query = $query . ' inner join ufs on ufs.id = mu.uf_id ';
        $query = $query . ' inner join faixa_etarias fe on fe.id = pa.faixa_etaria_id ';
        $query = $query . ' WHERE true ';
        return $query;
    }
    public function where($query){

        if(!empty($this->doenca)){
            $query = $query . ' and d.id = ' . $this->doenca;
        }
        if(!empty($this->uf)){
            $query = $query . ' and ufs.id = ' . $this->uf ;
        }
        if(!empty($this->municipio)){
            $query = $query . ' and mu.id = ' . $this->municipio;
        }
        if(!empty($this->faixa_etaria)){
            $query = $query . ' and fe.id = ' . $this->faixa_etaria;
        }
        if(!empty($this->sexo)){
            $query = $query . ' and pe.sexo = \'' . $this->sexo . '\'';
        }
        return $query;
    }

    public function orderBy($query){

        $query = $query . ' ORDER BY true ';

        if(!empty($this->doenca_ordem)){
            $query =  $query . ', d.nome ' . $this->doenca_ordem ;
        }

        if(!empty($this->uf_ordem)){
            $query =  $query . ', ufs.nome ' . $this->uf_ordem;
        }

        if(!empty($this->municipio_ordem)){
            $query =  $query . ', mu.nome ' . $this->municipio_ordem;
        }

        if(!empty($this->faixa_etaria_ordem)){
            $query =  $query . ', fe.idade_min ' . $this->faixa_etaria_ordem;
        }

        if(!empty($this->sexo_ordem)){
            $query =  $query . ', pe.sexo ' . $this->sexo_ordem;
        }

        return $query;
    }

    public function groupBy(){
        return  ' group by (d.id, ufs.id, mu.id, fe.id, pe.sexo) ';
    }
}
