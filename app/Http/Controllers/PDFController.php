<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    public function create_PDF_Ocorrencia($id_ocorrencia){
        $pdf = App::make('dompdf.wrapper');

        $ocorrencia = DB::table('ocorrencias')
                        ->select('id_ocorrencia', 'num_protocol', DB::raw('DATE_FORMAT(ocorrencias.data_hora, "%d/%m/%Y") as data'), DB::raw('DATE_FORMAT(ocorrencias.data_hora, "%H:%i:%s") as hora'), 'endereco_cep', 'endereco_num', 'endereco_rua', 
                                 'descricao_inicial', 'descricao_ocorrencia', 'id_bairro')
                        ->where('ocorrencias.id_ocorrencia', $id_ocorrencia)
                        ->first();
        
        $fatos = DB::table('ocorrencias_fatos_ocorrencias')
                   ->select(DB::raw('GROUP_CONCAT(fatos_ocorrencias.natureza SEPARATOR ", ") as fato_ocorrencia'))
                   ->leftJoin('fatos_ocorrencias', 'ocorrencias_fatos_ocorrencias.id_fato_ocorrencia', 'fatos_ocorrencias.id_fato_ocorrencia')
                   ->where('ocorrencias_fatos_ocorrencias.id_ocorrencia', $id_ocorrencia)
                   ->get();
        
        $pessoas = DB::table('pessoas')
                     ->select('pessoas.id_pessoa', 'pessoas.nome', 'pessoas.RG_CPF', DB::raw('DATE_FORMAT(pessoas.data_nascimento, "%d/%m/%Y") as data_nascimento'), 'pessoas.telefone', 'fotos_pessoas.caminho_servidor')
                     ->leftJoin('ocorrencias_pessoas', 'pessoas.id_pessoa', "ocorrencias_pessoas.id_pessoa")
                     ->leftJoin('fotos_pessoas', 'pessoas.id_pessoa', 'fotos_pessoas.id_pessoa')
                     ->where('ocorrencias_pessoas.id_ocorrencia', $id_ocorrencia)
                     ->groupBy('pessoas.id_pessoa')
                     ->get();
        
        $veiculos = DB::table('veiculos')
                      ->select('veiculos.placa', 'veiculos.cor', 'veiculos.renavam', 'veiculos.chassi', 'marcas_veiculos.marca', 'ocorrencias_veiculos.participacao')
                      ->leftJoin('marcas_veiculos', 'veiculos.id_marca_veiculo', 'marcas_veiculos.id_marca_veiculo')
                      ->leftJoin('ocorrencias_veiculos', 'veiculos.id_veiculo', 'ocorrencias_veiculos.id_veiculo')
                      ->where('ocorrencias_veiculos.id_ocorrencia', $id_ocorrencia)
                      ->get();

        $objetos_diversos = DB::table('objetos_diversos')
                              ->select('objetos_diversos.num_identificacao', 'objetos_diversos.modelo', 'objetos_diversos.marca',
                                    'tipos_objetos.objeto', 'objetos_diversos.un_medida', 'ocorrencias_objetos_diversos.quantidade')
                              ->leftJoin('ocorrencias_objetos_diversos', 'objetos_diversos.id_objeto_diverso', 'ocorrencias_objetos_diversos.id_objeto_diverso')
                              ->leftJoin('tipos_objetos', 'objetos_diversos.id_tipo_objeto', 'tipos_objetos.id_tipo_objeto')
                              ->where('ocorrencias_objetos_diversos.id_ocorrencia', $id_ocorrencia)
                              ->get();
        
        $armas = DB::table('armas')
                   ->select('armas.tipo', 'armas.especie', 'armas.fabricacao', 'armas.calibre', 'armas.num_serie')
                   ->leftJoin('ocorrencias_armas', 'armas.id_arma', 'ocorrencias_armas.id_arma')
                   ->where('ocorrencias_armas.id_ocorrencia', $id_ocorrencia)
                   ->get();

        $drogas = DB::table('drogas')
                    ->select('drogas.tipo', 'ocorrencias_drogas.quantidade', 'ocorrencias_drogas.un_medida')
                    ->leftJoin('ocorrencias_drogas', 'drogas.id_droga', 'ocorrencias_drogas.id_droga')
                    ->where('ocorrencias_drogas.id_ocorrencia', $id_ocorrencia)
                    ->get();
        
        $animais = DB::table('animais')
                     ->select('animais.especie', 'ocorrencias_animais.quantidade', 'ocorrencias_animais.participacao', 'ocorrencias_animais.observacao')
                     ->leftjoin('ocorrencias_animais', 'animais.id_animal', 'ocorrencias_animais.id_animal')
                     ->where('ocorrencias_animais.id_ocorrencia', $id_ocorrencia)
                     ->get();

        $endereco = (new OcorrenciaController)->get_Endereco($ocorrencia->id_bairro);

        $pdf->set_paper('A4', 'portrait');
        $pdf->loadHTML(view('pdf.ocorrencia_pdf', compact('ocorrencia', 'endereco', 'pessoas', 'veiculos', 'objetos_diversos', 'armas', 'drogas', 'animais', 'fatos')));

        return $pdf->stream('ocorrencia.pdf');
    }

    public function create_PDF_Pessoa($id_pessoa){
        $pdf = App::make('dompdf.wrapper');

        $pessoa = DB::table('pessoas')
                    ->select('pessoas.id_pessoa', 'pessoas.nome', 'pessoas.RG_CPF', 'pessoas.alcunha', 'pessoas.observacao', DB::raw('DATE_FORMAT(pessoas.data_nascimento, "%d/%m/%Y") as data_nascimento'), 'pessoas.telefone', 'fotos_pessoas.caminho_servidor')
                    ->leftJoin('fotos_pessoas', 'pessoas.id_pessoa', 'fotos_pessoas.id_pessoa')
                    ->where('pessoas.id_pessoa', $id_pessoa)
                    ->groupBy('pessoas.id_pessoa')
                    ->first();

        $ocorrencias = DB::table('ocorrencias_pessoas')
                         ->select(DB::raw('DATE_FORMAT(ocorrencias.data_hora, "%d/%m/%Y") as data'), DB::raw('DATE_FORMAT(ocorrencias.data_hora, "%H:%i:%s") as hora'),
                             'ocorrencias.num_protocol', 'ocorrencias.endereco_rua', 'ocorrencias.endereco_cep', 'ocorrencias.endereco_num', 'bairros.nome as endereco_bairro',
                             'cidades.nome as endereco_cidade', 'estados.sigla as endereco_estado', 'ocorrencias.descricao_inicial', 'ocorrencias.descricao_ocorrencia',
                             DB::raw('GROUP_CONCAT(fatos_ocorrencias.natureza SEPARATOR ", ") AS fato_ocorrencia'))
                         ->leftJoin('ocorrencias', 'ocorrencias_pessoas.id_ocorrencia', 'ocorrencias.id_ocorrencia')
                         ->leftJoin('ocorrencias_fatos_ocorrencias', 'ocorrencias.id_ocorrencia', 'ocorrencias_fatos_ocorrencias.id_ocorrencia')
                         ->leftJoin('fatos_ocorrencias', 'ocorrencias_fatos_ocorrencias.id_fato_ocorrencia', 'fatos_ocorrencias.id_fato_ocorrencia')
                         ->leftJoin('bairros', 'ocorrencias.id_bairro', 'bairros.id_bairro')
                         ->leftJoin('cidades', 'bairros.id_cidade', 'cidades.id_cidade')
                         ->leftJoin('estados', 'cidades.id_estado', 'estados.id_estado')
                         ->where('ocorrencias_pessoas.id_pessoa', $id_pessoa)
                         ->groupBy('ocorrencias.num_protocol')
                         ->get();

        $pdf->set_paper('A4', 'portrait');
        $pdf->loadHTML(view('pdf.pessoa_pdf', compact('pessoa', 'ocorrencias')));

        return $pdf->stream('pessoa.pdf');
    }
}
