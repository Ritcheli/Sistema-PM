<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnaliseOcorrenciaController extends Controller
{
    public function show_Analise_Ocorrencia(){
        return view('analise.analise_ocorrencia');
    }

    public function plot_SNA_Graph(Request $request){
        if ($request['tipo_rede'] == 'Pessoas'){ 
            $data = $this->plot_SNA_Pessoas($request['participacao'], $request['grupo_ocorr']);
        }

        return response()->json($data, 200);
    }

    public function plot_SNA_Pessoas($participacao, $grupo){
        $nodes = collect();
        $links = collect();
        $list_adicionados = array();

        $query = DB::table('ocorrencias_pessoas')
                   ->select('ocorrencias_pessoas.id_ocorrencia', 'pessoas.nome', 'pessoas.RG_CPF', 'ocorrencias_pessoas.id_pessoa', 'fotos_pessoas.caminho_servidor', 'grupos_fatos.nome as grupo')
                   ->join('pessoas', 'ocorrencias_pessoas.id_pessoa', 'pessoas.id_pessoa')
                   ->leftJoin('participacao_pessoas_fatos', 'ocorrencias_pessoas.id_ocorrencia_pessoa', 'participacao_pessoas_fatos.id_ocorrencia_pessoa')
                   ->leftJoin('fatos_ocorrencias', 'participacao_pessoas_fatos.id_fato_ocorrencia', 'fatos_ocorrencias.id_fato_ocorrencia')
                   ->leftJoin('grupos_fatos', 'fatos_ocorrencias.id_grupo_fato', 'grupos_fatos.id_grupo_fato')
                   ->leftJoin('fotos_pessoas', 'pessoas.id_pessoa', 'fotos_pessoas.id_pessoa')
                   ->whereIn('participacao_pessoas_fatos.participacao', $participacao);

        // Aplicação dos filtros de grupo
        if ($grupo == 'Furto_Roubo'){
            $query->whereIn('grupos_fatos.nome', ['Furto', 'Roubo']);
        }
        if ($grupo == 'Substancias'){
            $query->where('grupos_fatos.nome', 'Drogas');
        }

        $ocorrencias = $query->groupBy('ocorrencias_pessoas.id_pessoa')
                             ->groupBy('ocorrencias_pessoas.id_ocorrencia')
                             ->get();

        foreach ($ocorrencias as $ocorrencia){
            // Adiciona um novo nodo, contendo id e label
            if ($nodes->contains('data.id', $ocorrencia->id_pessoa) == false)
            {
                $nodes->push(['data' => ['id'     => $ocorrencia->id_pessoa, 
                                         'label'  => $ocorrencia->nome,
                                         'RG_CPF' => $ocorrencia->RG_CPF,
                                         'foto'   => $ocorrencia->caminho_servidor]]);
            }

            // Verifica se os relacionamentos da ocorrência já foram adicionados
            if (array_search($ocorrencia->id_ocorrencia, $list_adicionados) == ''){
                array_push($list_adicionados, $ocorrencia->id_ocorrencia);

                $relacoes = $ocorrencias->where('id_ocorrencia', $ocorrencia->id_ocorrencia);

                // Se houver mais de duas pessoas relacionadas ao mesmo BO executa este script
                // Faz a iteração entre todos os integrantes de uma mesma ocorrência
                if ($relacoes->count() > 2)
                {
                    for ($i = 1; $i < $relacoes->count(); $i++){
                        // Remove o primeiro elemento do collection $count_relacoes e o coloca no $count_relacoes_aux
                        $relacoes_aux = collect([$relacoes->shift()]);
                        
                        // Realiza a permutação entre o $coll_Aux_1 e o $coll_Aux_1
                        $result_permutacoes = $relacoes->crossJoin($relacoes_aux);   

                        // Alimenta o collection das arestas a partir da permutação dos dois valores collection
                        foreach ($result_permutacoes as $result_permutacao)
                        {
                            $links->push(['data' => ['source' => $result_permutacao[1]->id_pessoa,
                                                     'target' => $result_permutacao[0]->id_pessoa]]);
                        }
                    }

                    $links->push(['data' => ['source' => $relacoes->first()->id_pessoa,
                                             'target' => $relacoes->last()->id_pessoa]]);    
                } 
                // Caso somente haja duas pessoas em uma mesma ocorrência não há necessidade de se fazer uma permutação 
                // entre os envolvidos
                else if ($relacoes->count() == 2)
                {
                    $links->push(['data' => ['source' => $relacoes->first()->id_pessoa,
                                             'target' => $relacoes->last()->id_pessoa]]);
                }
            }
        }

        $data = ($nodes->merge($links));

        return $data;
    }

    public function plot_SNA_Pessoa_Fato_Ocorrencia(){
        $nodes     = collect();
        $links     = collect(); 

        // Relação de pessoas e fatos_ocorrencias, a grossura da aresta é dada pela quantidade de vezes que uma pessoa está associada a um mesmo fato
        $pessoas_fatos = DB::table('fatos_ocorrencias')
                           ->select('fatos_ocorrencias.id_fato_ocorrencia', 'fatos_ocorrencias.natureza', 'pessoas.id_pessoa', 'pessoas.nome', 'pessoas.RG_CPF', DB::raw('count(pessoas.id_pessoa) as count_pessoa'), 'fotos_pessoas.caminho_servidor')
                           ->join('ocorrencias_fatos_ocorrencias', 'fatos_ocorrencias.id_fato_ocorrencia', 'ocorrencias_fatos_ocorrencias.id_fato_ocorrencia')
                           ->join('ocorrencias', 'ocorrencias_fatos_ocorrencias.id_ocorrencia', 'ocorrencias.id_ocorrencia')
                           ->join('ocorrencias_pessoas', 'ocorrencias.id_ocorrencia', 'ocorrencias_pessoas.id_ocorrencia')
                           ->join('pessoas', 'ocorrencias_pessoas.id_pessoa', 'pessoas.id_pessoa')
                           ->leftJoin('fotos_pessoas', 'pessoas.id_pessoa', 'fotos_pessoas.id_pessoa')
                           ->groupBy('pessoas.id_pessoa')
                           ->groupBy('fatos_ocorrencias.id_fato_ocorrencia')
                           ->get();

        // Relação de fatos e a quantidade de vezes que aparecem
        $fatos = DB::table('fatos_ocorrencias')
                   ->select('fatos_ocorrencias.id_fato_ocorrencia', 'fatos_ocorrencias.natureza', DB::raw('count(fatos_ocorrencias.natureza) as total_natureza'))
                   ->join('ocorrencias_fatos_ocorrencias', 'fatos_ocorrencias.id_fato_ocorrencia', 'ocorrencias_fatos_ocorrencias.id_fato_ocorrencia')
                   ->join('ocorrencias', 'ocorrencias_fatos_ocorrencias.id_ocorrencia', 'ocorrencias.id_ocorrencia')
                   ->groupBy('fatos_ocorrencias.natureza')
                   ->get();

        foreach ($fatos as $fato){
            $nodes->push(['id'    => strval($fato->id_fato_ocorrencia) . strval($fato->natureza),
                          'label' => $fato->natureza,
                          'size'  => $fato->total_natureza,
                          'color' => '#035efc',
                          'type'  => 'fato'
            ]);
        }

        foreach ($pessoas_fatos as $pessoa_fato){ 
            $links->push(['source' => strval($pessoa_fato->id_pessoa) . $pessoa_fato->nome,
                          'target' => strval($pessoa_fato->id_fato_ocorrencia) . $pessoa_fato->natureza,
                          'weight' => $pessoa_fato->count_pessoa]);

            if ($nodes->doesntContain('id' ,strval($pessoa_fato->id_pessoa) . $pessoa_fato->nome)){
                $nodes->push(['id'     => strval($pessoa_fato->id_pessoa) . $pessoa_fato->nome,
                              'label'  => $pessoa_fato->nome,
                              'foto'   => $pessoa_fato->caminho_servidor,
                              'RG_CPF' => $pessoa_fato->RG_CPF,     
                              'size'   => 1,
                              'color'  => '#fc6203',
                              'type'   => 'pessoa'                    
                ]);
            }
        }

        $subtitles = collect([
            ['type'  => 'Fato',
             'color' => '#035efc'],
            ['type'  => 'Pessoa',
            'color' => '#fc6203'],
        ]); 

        $data['nodes']     = $nodes;
        $data['links']     = $links;
        $data['subtitles'] = $subtitles;

        return response()->json($data, 200);
    }
}