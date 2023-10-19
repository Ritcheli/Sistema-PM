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
        if ($request['tipo_rede'] == 'Pessoas_Fatos'){
            $data = $this->plot_SNA_Pessoas_Fatos($request['participacao']);
        }
        if ($request['tipo_rede'] == 'Pessoas_Grupos'){
            $data = $this->plot_SNA_Pessoas_Grupos($request['participacao']);
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

    public function plot_SNA_Pessoas_Fatos($participacao){
        $nodes     = collect();
        $links     = collect();

        // Relação de pessoas e fatos_ocorrencias, a grossura da aresta é dada pela quantidade de vezes que uma pessoa está associada a um mesmo fato
        $pessoas_fatos = DB::table('fatos_ocorrencias')
                           ->select('fatos_ocorrencias.id_fato_ocorrencia', 'fatos_ocorrencias.natureza', 'ocorrencias_pessoas.id_ocorrencia', 'pessoas.id_pessoa',
                                     'pessoas.nome', 'pessoas.RG_CPF', 'fotos_pessoas.caminho_servidor', DB::raw('count(*) as count_pessoa'))
                           ->from('fatos_ocorrencias')
                           ->join('participacao_pessoas_fatos', 'fatos_ocorrencias.id_fato_ocorrencia', 'participacao_pessoas_fatos.id_fato_ocorrencia')
                           ->join('ocorrencias_pessoas', 'participacao_pessoas_fatos.id_ocorrencia_pessoa', 'ocorrencias_pessoas.id_ocorrencia_pessoa')
                           ->join('pessoas', 'ocorrencias_pessoas.id_pessoa', 'pessoas.id_pessoa')
                           ->leftJoin('fotos_pessoas', 'pessoas.id_pessoa', 'fotos_pessoas.id_pessoa')
                           ->groupBy('fatos_ocorrencias.id_fato_ocorrencia', 'pessoas.id_pessoa')
                           ->whereIn('participacao_pessoas_fatos.participacao', $participacao)
                           ->get();

        // Relação de fatos e a quantidade de vezes que aparecem
        $fatos = DB::table('fatos_ocorrencias')
                   ->distinct()
                   ->select('fatos_ocorrencias.id_fato_ocorrencia', 'ocorrencias_pessoas.id_ocorrencia', 'fatos_ocorrencias.natureza')
                   ->join('participacao_pessoas_fatos', 'fatos_ocorrencias.id_fato_ocorrencia', 'participacao_pessoas_fatos.id_fato_ocorrencia')
                   ->join('ocorrencias_pessoas', 'participacao_pessoas_fatos.id_ocorrencia_pessoa', 'ocorrencias_pessoas.id_ocorrencia_pessoa')
                   ->whereIn('participacao_pessoas_fatos.participacao', $participacao)
                   ->get();

        $count_fatos = $fatos->countBy('natureza');

        foreach ($fatos as $fato){
            $nodes->push(['data' => ['id'    => strval($fato->id_fato_ocorrencia) . strval($fato->natureza),
                                     'label' => $fato->natureza,
                                     'size'  => $count_fatos[$fato->natureza],
                                     'color' => '#035efc',
                                     'type'  => 'fato']
                        ]);
        }

        foreach ($pessoas_fatos as $pessoa_fato){ 
            $links->push(['data' => ['source' => strval($pessoa_fato->id_pessoa) . $pessoa_fato->nome,
                                     'target' => strval($pessoa_fato->id_fato_ocorrencia) . $pessoa_fato->natureza,
                                     'weight' => $pessoa_fato->count_pessoa]
                        ]);

            if ($nodes->doesntContain('id' ,strval($pessoa_fato->id_pessoa) . $pessoa_fato->nome)){
                $nodes->push(['data' => ['id'     => strval($pessoa_fato->id_pessoa) . $pessoa_fato->nome,
                                         'label'  => $pessoa_fato->nome,
                                         'foto'   => $pessoa_fato->caminho_servidor,
                                         'RG_CPF' => $pessoa_fato->RG_CPF,     
                                         'size'   => 2,
                                         'color'  => '#fc6203',
                                         'type'   => 'pessoa']                    
                            ]);
            }
        }

        $subtitles = collect([
            ['type'  => 'Fato',
             'color' => '#035efc'],
            ['type'  => 'Pessoa',
             'color' => '#fc6203'],
        ]); 

        $data['graph'] = ($nodes->merge($links));
        $data['subtitles'] = $subtitles;

        return $data;
    }

    public function plot_SNA_Pessoas_Grupos($participacao){
        $nodes     = collect();
        $links     = collect();

        // Relação de pessoas e grupos_fatos, a grossura da aresta é dada pela quantidade de vezes que uma pessoa está associada a um mesmo fato
        $pessoas_grupos =  DB::table('fatos_ocorrencias')
                             ->select('grupos_fatos.id_grupo_fato', 'grupos_fatos.nome as grupo', 'ocorrencias_pessoas.id_ocorrencia', 'pessoas.id_pessoa',
                                     'pessoas.nome as pessoa', 'pessoas.RG_CPF', 'fotos_pessoas.caminho_servidor', DB::raw('COUNT(*) as count_pessoa'))
                             ->join('grupos_fatos', 'fatos_ocorrencias.id_grupo_fato', 'grupos_fatos.id_grupo_fato')
                             ->join('participacao_pessoas_fatos', 'fatos_ocorrencias.id_fato_ocorrencia', 'participacao_pessoas_fatos.id_fato_ocorrencia')
                             ->join('ocorrencias_pessoas', 'participacao_pessoas_fatos.id_ocorrencia_pessoa', 'ocorrencias_pessoas.id_ocorrencia_pessoa')
                             ->join('pessoas', 'ocorrencias_pessoas.id_pessoa', 'pessoas.id_pessoa')
                             ->leftJoin('fotos_pessoas', 'pessoas.id_pessoa', 'fotos_pessoas.id_pessoa')
                             ->groupBy('grupos_fatos.id_grupo_fato', 'pessoas.id_pessoa')
                             ->whereIn('participacao_pessoas_fatos.participacao', $participacao)
                             ->get(); 
        
        // Relação de grupos e a quantidade de vezes que aparecem
        $grupos = DB::table('fatos_ocorrencias')
                    ->select('ocorrencias_pessoas.id_ocorrencia', 'grupos_fatos.id_grupo_fato', 'grupos_fatos.nome')
                    ->distinct()
                    ->join('grupos_fatos', 'fatos_ocorrencias.id_grupo_fato', 'grupos_fatos.id_grupo_fato')
                    ->join('participacao_pessoas_fatos', 'fatos_ocorrencias.id_fato_ocorrencia', 'participacao_pessoas_fatos.id_fato_ocorrencia')
                    ->join('ocorrencias_pessoas', 'participacao_pessoas_fatos.id_ocorrencia_pessoa', 'ocorrencias_pessoas.id_ocorrencia_pessoa')
                    ->whereIn('participacao_pessoas_fatos.participacao', $participacao)
                    ->get(); 

        $count_grupos = $grupos->countBy('nome');

        $unique_grupos = $grupos->unique('id_grupo_fato'); 

        foreach ($unique_grupos as $unique_grupo){
            $nodes->push(['data' => ['id'    => strval($unique_grupo->id_grupo_fato) . strval($unique_grupo->nome),
                                     'label' => $unique_grupo->nome,
                                     'size'  => $count_grupos[$unique_grupo->nome],
                                     'color' => '#035efc',
                                     'type'  => 'grupo']
                        ]);
        }

        foreach ($pessoas_grupos as $pessoa_grupo){ 
            $links->push(['data' => ['source' => strval($pessoa_grupo->id_pessoa) . $pessoa_grupo->pessoa,
                                     'target' => strval($pessoa_grupo->id_grupo_fato) . $pessoa_grupo->grupo,
                                     'weight' => $pessoa_grupo->count_pessoa]
                        ]);

            if ($nodes->doesntContain('id' ,strval($pessoa_grupo->id_pessoa) . $pessoa_grupo->pessoa)){
                $nodes->push(['data' => ['id'     => strval($pessoa_grupo->id_pessoa) . $pessoa_grupo->pessoa,
                                         'label'  => $pessoa_grupo->pessoa,
                                         'foto'   => $pessoa_grupo->caminho_servidor,
                                         'RG_CPF' => $pessoa_grupo->RG_CPF,     
                                         'size'   => 2,
                                         'color'  => '#fc6203',
                                         'type'   => 'pessoa']                    
                            ]);
            }
        }

        $subtitles = collect([
            ['type'  => 'Grupo',
             'color' => '#035efc'],
            ['type'  => 'Pessoa',
             'color' => '#fc6203'],
        ]); 

        $data['graph'] = ($nodes->merge($links));
        $data['subtitles'] = $subtitles;

        return $data;
    }
}