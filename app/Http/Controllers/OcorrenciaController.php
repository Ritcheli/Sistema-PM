<?php

namespace App\Http\Controllers;

use App\Models\ocorrencias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OcorrenciaController extends Controller
{
    public function show_Cad_Ocorrencia(){
        $Who_Call = "Cad_Ocorrencia";
        
        $tipos_objetos = DB::table('tipos_objetos')
                           ->select('objeto')
                           ->orderBy('objeto')
                           ->get();

        $fatos_ocorrencias = DB::table('fatos_ocorrencias')
                               ->select('fatos_ocorrencias.natureza', 'fatos_ocorrencias.id_fato_ocorrencia')
                               ->get();

        return view('ocorrencia.ocorrencia', compact('Who_Call', 'fatos_ocorrencias', 'tipos_objetos'));
    }

    public function show_Visualizar_Ocorrencia($id_ocorrencia){
        $ocorrencia = DB::table('ocorrencias')
                        ->select('id_ocorrencia', 'num_protocol', DB::raw('DATE_FORMAT(ocorrencias.data_hora, "%d/%m/%Y") as data'), DB::raw('DATE_FORMAT(ocorrencias.data_hora, "%H:%i:%s") as hora'), 'endereco_cep', 'endereco_num', 'endereco_rua', 
                                 'descricao_inicial', 'descricao_ocorrencia', 'id_bairro')
                        ->where('ocorrencias.id_ocorrencia', $id_ocorrencia)
                        ->get();

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
                                       'objetos_diversos.un_medida', 'ocorrencias_objetos_diversos.quantidade', 'tipos_objetos.objeto')
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

        $endereco = $this->get_Endereco($ocorrencia[0]->id_bairro);

        return view('ocorrencia.visualizar_ocorrencia', compact('ocorrencia', 'pessoas', 'endereco', 'fatos', 'veiculos', 'objetos_diversos', 'armas', 'drogas', 'animais'));
    }

    public function show_Editar_Ocorrencia($id_ocorrencia){
        $Who_Call = "Editar_Ocorrencia";

        $ocorrencia = DB::table('ocorrencias')
                        ->where('id_ocorrencia', $id_ocorrencia)
                        ->get();

        $pessoas = DB::table('pessoas')
                     ->select('pessoas.id_pessoa', 'pessoas.nome', 'pessoas.RG_CPF', DB::raw('GROUP_CONCAT(CONCAT(participacao_pessoas_fatos.participacao, ":", fatos_ocorrencias.natureza) SEPARATOR "|") AS participacao'))
                     ->leftJoin('ocorrencias_pessoas', 'pessoas.id_pessoa', 'ocorrencias_pessoas.id_pessoa')
                     ->leftJoin('participacao_pessoas_fatos', 'ocorrencias_pessoas.id_ocorrencia_pessoa', 'participacao_pessoas_fatos.id_ocorrencia_pessoa')
                     ->leftJoin('fatos_ocorrencias', 'participacao_pessoas_fatos.id_fato_ocorrencia', 'fatos_ocorrencias.id_fato_ocorrencia')
                     ->where('ocorrencias_pessoas.id_ocorrencia', $id_ocorrencia)
                     ->groupBy('pessoas.id_pessoa', 'pessoas.nome', 'pessoas.RG_CPF')
                     ->get();    
        
        Log::debug($pessoas);
        
        $endereco = $this->get_Endereco($ocorrencia[0]->id_bairro);

        $veiculos = DB::table('ocorrencias_veiculos')
                        ->select('veiculos.id_veiculo', 'veiculos.placa', 'veiculos.cor', 'marcas_veiculos.marca', 'ocorrencias_veiculos.participacao')
                        ->where('id_ocorrencia', $id_ocorrencia)
                        ->leftJoin('veiculos', 'ocorrencias_veiculos.id_veiculo', 'veiculos.id_veiculo')
                        ->leftJoin('marcas_veiculos', 'veiculos.id_marca_veiculo', 'marcas_veiculos.id_marca_veiculo')
                        ->get();
        
        $tipos_objetos = DB::table('tipos_objetos')
                           ->select('objeto')
                           ->orderBy('objeto')
                           ->get();

        $objetos_diversos = DB::table('ocorrencias_objetos_diversos')
                              ->select('objetos_diversos.*', 'ocorrencias_objetos_diversos.quantidade', 'tipos_objetos.objeto')
                              ->where('id_ocorrencia', $id_ocorrencia)
                              ->leftJoin('objetos_diversos', 'ocorrencias_objetos_diversos.id_objeto_diverso', 'objetos_diversos.id_objeto_diverso')
                              ->leftJoin('tipos_objetos', 'objetos_diversos.id_tipo_objeto', 'tipos_objetos.id_tipo_objeto')
                              ->get();
        
        $armas = DB::table('ocorrencias_armas')
                   ->select('armas.*')
                   ->where('id_ocorrencia', $id_ocorrencia)
                   ->leftJoin('armas', 'ocorrencias_armas.id_arma', 'armas.id_arma')
                   ->get();
        
        $drogas = DB::table('ocorrencias_drogas')
                    ->select('drogas.tipo', 'ocorrencias_drogas.quantidade', 'ocorrencias_drogas.un_medida')
                    ->where('id_ocorrencia', $id_ocorrencia)
                    ->leftJoin('drogas', 'ocorrencias_drogas.id_droga', 'drogas.id_droga')
                    ->get();

        $animais = DB::table('ocorrencias_animais')
                     ->select('animais.especie', 'ocorrencias_animais.quantidade', 
                              'ocorrencias_animais.observacao', 'ocorrencias_animais.participacao')
                     ->where('id_ocorrencia', $id_ocorrencia)
                     ->leftJoin('animais', 'ocorrencias_animais.id_animal', 'animais.id_animal')
                     ->get();
        
        $ocr_fatos_ocorrencias = DB::table('ocorrencias_fatos_ocorrencias')
                                   ->select('ocorrencias_fatos_ocorrencias.id_fato_ocorrencia')
                                   ->where('ocorrencias_fatos_ocorrencias.id_ocorrencia', $id_ocorrencia)
                                   ->get();

        $fatos_ocorrencias = DB::table('fatos_ocorrencias')
                               ->select('fatos_ocorrencias.natureza', 'fatos_ocorrencias.id_fato_ocorrencia')
                               ->get();

        return view('ocorrencia.ocorrencia', compact('Who_Call', 'ocorrencia', 'pessoas', 'endereco', 'veiculos', 'objetos_diversos', 'armas', 'drogas', 'animais', 'fatos_ocorrencias', 'ocr_fatos_ocorrencias', 'tipos_objetos'));
    }

    public function show_Busca_Ocorrencia(Request $request){
        $num_protocol = $request->input_num_protocol;
        $descricao    = $request->input_descricao;
        $pessoa       = $request->input_pessoa;
        $data_inicial = $request->data_inicial_ocorr;
        $data_final   = $request->data_final_ocorr;

        $query = DB::table('ocorrencias')
                   ->leftJoin('ocorrencias_pessoas', 'ocorrencias.id_ocorrencia', '=', 'ocorrencias_pessoas.id_ocorrencia')
                   ->leftJoin('pessoas', 'ocorrencias_pessoas.id_pessoa', '=', 'pessoas.id_pessoa')
                   ->select('ocorrencias.id_ocorrencia', 'ocorrencias.num_protocol', 'ocorrencias.descricao_ocorrencia', DB::raw('DATE_FORMAT(ocorrencias.data_hora, "%d/%m/%Y %H:%i:%s") as data_hora'), DB::raw('GROUP_CONCAT(pessoas.nome SEPARATOR " - ") AS pessoas_envolvidas'))
                   ->groupBy('ocorrencias.id_ocorrencia', 'ocorrencias.num_protocol', 'ocorrencias.descricao_ocorrencia', 'ocorrencias.data_hora');
        
        // --------------------------------- Filtros ---------------------------------
        if ($request->input_num_protocol != null){
            $query->where('ocorrencias.num_protocol', $num_protocol);
        }

        if ($request->input_descricao != null){
            $query->where('ocorrencias.descricao_ocorrencia', 'like', '%' . $descricao . '%');
        }

        if ($request->input_pessoa != null){
            $query->whereIn('ocorrencias.id_ocorrencia', function ($subquery) use ($pessoa) {
                $subquery->select('ocorrencias_pessoas.id_ocorrencia')
                         ->from('ocorrencias_pessoas')
                         ->leftJoin('pessoas', 'ocorrencias_pessoas.id_pessoa', '=', 'pessoas.id_pessoa')
                         ->where('pessoas.nome', 'like', '%' . $pessoa . '%');
            });
        }

        if ($request->data_inicial_ocorr != null){
            $query->whereDate('ocorrencias.data_hora', '>=', $data_inicial);
        }

        if ($request->data_final_ocorr != null){
            $query->whereDate('ocorrencias.data_hora', '<=', $data_final);
        }

        $ocorrencias = $query->paginate(10);

        return view('ocorrencia.busca_ocorrencia', compact('ocorrencias', 'num_protocol', 'descricao', 'pessoa', 'data_inicial', 'data_final'));
    }

    public function nova_Ocorrencia(Request $request){
        $validator = Validator::make($request->all(), [
            'num_protocol'    => ['required', 'unique:ocorrencias'],
            'tipo_ocorrencia' => ['required'],
            'data_hora'       => ['required'],
            'endereco_estado' => ['required'],
            'endereco_cidade' => ['required'],
            'endereco_bairro' => ['required'],
            'endereco_rua'    => ['max:60'],
            'descricao'       => ['required']
        ]);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }

        $dados_ocor = $request->only('num_protocol', 'data_hora', 'endereco_cep', 'endereco_numero', 'endereco_rua', 'descricao', 'envolvidos');
        
        // Configuração do cadastro do endereço
        $dados_bairro = $request->only('endereco_bairro');
        $dados_cidade = $request->only('endereco_cidade');
        $dados_estado = $request->only('endereco_estado');

        $dados_ocor['id_bairro'] = $this->salvar_Endereco($dados_estado, $dados_cidade, $dados_bairro);

        $ocorrencia = $this->create($dados_ocor);

        // --------------------- Seção de cadastro das informações extras das tabelas ocorrencias_extraidas e ocorrencias --------------------- //

        // Cadastro de fatos de ocorrências
        $fatos_ocorr = explode(',', request()->only('tipo_ocorrencia')['tipo_ocorrencia']);

        foreach ($fatos_ocorr as $fato_ocorr){
            $dados_fatos_ocorrencia['id_fato_ocorrencia'] = $fato_ocorr;
            $dados_fatos_ocorrencia['id_ocorrencia']      = $ocorrencia->id_ocorrencia;

            (new OcorrenciaFatoOcorrenciaController)->create($dados_fatos_ocorrencia);
        }

        // Cadastro de envolvidos relacionados a ocorrência
        if ($request->has('envolvidos')){
            $dados_envolvidos = $request->only('envolvidos');

            for ($i = 0; $i < count($dados_envolvidos['envolvidos']); $i++){
                $dados_env['id_pessoa']     = json_decode($dados_envolvidos['envolvidos'][$i])->id_envolvido;
                $dados_env['id_ocorrencia'] = $ocorrencia->id_ocorrencia;

                $ocorrencia_pessoa =  (new OcorrenciaPessoaController)->create($dados_env);

                $participacoes = explode('|', json_decode($dados_envolvidos['envolvidos'][$i])->participacao);

                if ($participacoes[0] != ""){
                    foreach ($participacoes as $participacao){
                        $fato_participacao = explode(':', $participacao);
                        
                        $fato = DB::table('fatos_ocorrencias')
                                    ->select('fatos_ocorrencias.id_fato_ocorrencia')
                                    ->where('fatos_ocorrencias.natureza', trim($fato_participacao[1]))
                                    ->first();
    
                        $participacao_pessoa_fato['id_ocorrencia_pessoa'] = $ocorrencia_pessoa->id_ocorrencia_pessoa;
                        $participacao_pessoa_fato['id_fato_ocorrencia']   = $fato->id_fato_ocorrencia;    
                        $participacao_pessoa_fato['participacao']         = trim($fato_participacao[0]);
    
                        (new ParticipacaoPessoaFatoController)->create($participacao_pessoa_fato);
                    }
                }
            }
        }

        // Cadastro de veiculos relacionados a ocorrência
        if ($request->has('veiculos')){
            $dados_veiculos = $request->only('veiculos');

            for ($i = 0; $i < count($dados_veiculos['veiculos']); $i++){
                $dados_veiculos_ocorr['id_veiculo']   = json_decode($dados_veiculos['veiculos'][$i])->id_veiculo;
                $dados_veiculos_ocorr['participacao'] = json_decode($dados_veiculos['veiculos'][$i])->participacao;

                $dados_veiculos_ocorr['id_ocorrencia'] = $ocorrencia->id_ocorrencia;

                (new OcorrenciaVeiculoController)->create($dados_veiculos_ocorr);
            }
        }

        // Cadastro de objetos relacionados a ocorrência
        if ($request->has('objetos')){
            $dados_objetos = $request->only('objetos');

            for ($i = 0; $i < count($dados_objetos['objetos']); $i++){
                $tipo_objeto['objeto'] = json_decode($dados_objetos['objetos'][$i])->tipo_objeto;

                $dados_objetos_novo['id_tipo_objeto']    = (new TipoObjetoController)->create($tipo_objeto);
                $dados_objetos_novo['num_identificacao'] = json_decode($dados_objetos['objetos'][$i])->num_identificacao;
                $dados_objetos_novo['modelo']            = json_decode($dados_objetos['objetos'][$i])->modelo_objeto;
                $dados_objetos_novo['marca']             = json_decode($dados_objetos['objetos'][$i])->marca_objeto;
                $dados_objetos_novo['un_medida']         = json_decode($dados_objetos['objetos'][$i])->un_med;

                $objeto = (new ObjetoDiversoController)->create($dados_objetos_novo);

                $dados_objetos_ocorr['id_ocorrencia']     = $ocorrencia->id_ocorrencia;
                $dados_objetos_ocorr['id_objeto_diverso'] = $objeto->id_objeto_diverso;
                $dados_objetos_ocorr['quantidade']        = json_decode($dados_objetos['objetos'][$i])->quantidade;

                (new OcorrenciaObjetoDiversoController)->create($dados_objetos_ocorr);
            }
        }

        // Cadastro de armas relacionados a ocorrência
        if ($request->has('armas')){
            $dados_armas = $request->only('armas');

            for ($i = 0; $i < count($dados_armas['armas']); $i++){
                $dados_armas_novo['tipo']       = json_decode($dados_armas['armas'][$i])->tipo;
                $dados_armas_novo['especie']    = json_decode($dados_armas['armas'][$i])->especie;
                $dados_armas_novo['fabricacao'] = json_decode($dados_armas['armas'][$i])->fabricacao;
                $dados_armas_novo['calibre']    = json_decode($dados_armas['armas'][$i])->calibre;
                $dados_armas_novo['num_serie']  = json_decode($dados_armas['armas'][$i])->num_serie;

                $arma = (new ArmaController)->create($dados_armas_novo);

                $dados_armas_ocorr['id_ocorrencia'] = $ocorrencia->id_ocorrencia;
                $dados_armas_ocorr['id_arma']       = $arma->id_arma;

                (new OcorrenciaArmaController)->create($dados_armas_ocorr);
            }
        }

        // Cadastro de drogas relacionados a ocorrência
        if ($request->has('drogas')){
            $dados_drogas = $request->only('drogas');

            for ($i = 0; $i < count($dados_drogas['drogas']); $i++){
                $dados_drogas_novo['tipo'] = json_decode($dados_drogas['drogas'][$i])->tipo;

                $droga = (new DrogaController)->create($dados_drogas_novo);

                $dados_drogas_ocorr['id_droga']      = $droga;
                $dados_drogas_ocorr['id_ocorrencia'] = $ocorrencia->id_ocorrencia;
                $dados_drogas_ocorr['quantidade']    = json_decode($dados_drogas['drogas'][$i])->quantidade;
                $dados_drogas_ocorr['un_medida']     = json_decode($dados_drogas['drogas'][$i])->un_medida;

                (new OcorrenciaDrogaController)->create($dados_drogas_ocorr);
            }
        }

        // Cadastro de animais relacionados a ocorrência
        if ($request->has('animais')){
            $dados_animais = $request->only('animais');

            for ($i = 0; $i < count($dados_animais['animais']); $i++){
                $dados_animais_novo['especie'] = json_decode($dados_animais['animais'][$i])->especie;

                $animal = (new AnimalController)->create($dados_animais_novo);
                
                $dados_animais_ocorr['id_ocorrencia'] = $ocorrencia->id_ocorrencia;
                $dados_animais_ocorr['id_animal']     = $animal;
                $dados_animais_ocorr['quantidade']    = json_decode($dados_animais['animais'][$i])->quantidade;
                $dados_animais_ocorr['observacao']    = json_decode($dados_animais['animais'][$i])->participacao;
                $dados_animais_ocorr['participacao']  = json_decode($dados_animais['animais'][$i])->outras_info;

                (new OcorrenciaAnimalController)->create($dados_animais_ocorr);
            }
        }

        alert('Sucesso','Ocorrência cadastrada', 'success')->showConfirmButton('Continuar');
        
        return route('show_Dashboard');
    }

    public function editar_Ocorrencia(Request $request){
        $validator = Validator::make($request->all(), [
            'num_protocol'    => ['required'],
            'data_hora'       => ['required'],
            'tipo_ocorrencia' => ['required'],
            'endereco_estado' => ['required'],
            'endereco_cidade' => ['required'],
            'endereco_bairro' => ['required'],
            'endereco_rua'    => ['max:60'],
            'descricao'       => ['required']
        ]);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }
        
        $dados_ocor = $request->only('id_ocorrencia', 'num_protocol', 'data_hora', 'endereco_cep', 'endereco_numero', 'endereco_rua', 'descricao', 'envolvidos');

        // Configuração do cadastro do endereço
        $dados_bairro = $request->only('endereco_bairro');
        $dados_cidade = $request->only('endereco_cidade');
        $dados_estado = $request->only('endereco_estado');

        $dados_ocor['id_bairro'] = $this->salvar_Endereco($dados_estado, $dados_cidade, $dados_bairro);

        $this->update($dados_ocor);

        $this->excluir_Tabelas_Intermediarias($dados_ocor['id_ocorrencia']);

        $fatos_ocorr = explode(',', request()->only('tipo_ocorrencia')['tipo_ocorrencia']);

        foreach ($fatos_ocorr as $fato_ocorr){
            $dados_fatos_ocorrencia['id_fato_ocorrencia'] = $fato_ocorr;
            $dados_fatos_ocorrencia['id_ocorrencia']      = $dados_ocor['id_ocorrencia'];

            (new OcorrenciaFatoOcorrenciaController)->create($dados_fatos_ocorrencia);
        }

        // Atuliza as pessoas relacionadas as ocorrências
        if ($request->has('envolvidos')){
            $dados_envolvidos = $request->only('envolvidos');

            for ($i = 0; $i < count($dados_envolvidos['envolvidos']); $i++){
                $dados_env['id_pessoa']     = json_decode($dados_envolvidos['envolvidos'][$i])->id_envolvido;
                $dados_env['id_ocorrencia'] = $dados_ocor['id_ocorrencia'];

                $ocorrencia_pessoa = (new OcorrenciaPessoaController)->create($dados_env);

                $participacoes = explode('|', json_decode($dados_envolvidos['envolvidos'][$i])->participacao);

                if ($participacoes[0] != ""){
                    foreach ($participacoes as $participacao){
                        $fato_participacao = explode(':', $participacao);
                        
                        $fato = DB::table('fatos_ocorrencias')
                                    ->select('fatos_ocorrencias.id_fato_ocorrencia')
                                    ->where('fatos_ocorrencias.natureza', trim($fato_participacao[1]))
                                    ->first();
    
                        $participacao_pessoa_fato['id_ocorrencia_pessoa'] = $ocorrencia_pessoa->id_ocorrencia_pessoa;
                        $participacao_pessoa_fato['id_fato_ocorrencia']   = $fato->id_fato_ocorrencia;    
                        $participacao_pessoa_fato['participacao']         = trim($fato_participacao[0]);
    
                        (new ParticipacaoPessoaFatoController)->create($participacao_pessoa_fato);
                    }
                }
            }
        }

        // Atuliza os veículos relacionados as ocorrências
        if ($request->has('veiculos')){
            $dados_veiculos = $request->only('veiculos');

            for ($i = 0; $i < count($dados_veiculos['veiculos']); $i++){
                $dados_veiculos_ocorr['id_veiculo']    = json_decode($dados_veiculos['veiculos'][$i])->id_veiculo;
                $dados_veiculos_ocorr['participacao']  = json_decode($dados_veiculos['veiculos'][$i])->participacao;
                $dados_veiculos_ocorr['id_ocorrencia'] = $dados_ocor['id_ocorrencia'];

                (new OcorrenciaVeiculoController)->create($dados_veiculos_ocorr);
            }
        }

        // Atualiza os objetos relacionados a ocorrência
        if ($request->has('objetos')){
            $dados_objetos = $request->only('objetos');

            for ($i = 0; $i < count($dados_objetos['objetos']); $i++){
                $tipo_objeto['objeto'] = json_decode($dados_objetos['objetos'][$i])->tipo_objeto;

                $dados_objetos_novo['id_tipo_objeto']    = (new TipoObjetoController)->create($tipo_objeto);
                $dados_objetos_novo['num_identificacao'] = json_decode($dados_objetos['objetos'][$i])->num_identificacao;
                $dados_objetos_novo['modelo']            = json_decode($dados_objetos['objetos'][$i])->modelo_objeto;
                $dados_objetos_novo['marca']             = json_decode($dados_objetos['objetos'][$i])->marca_objeto;
                $dados_objetos_novo['un_medida']         = json_decode($dados_objetos['objetos'][$i])->un_med;

                $objeto = (new ObjetoDiversoController)->create($dados_objetos_novo);

                $dados_objetos_ocorr['id_ocorrencia']     = $dados_ocor['id_ocorrencia'];
                $dados_objetos_ocorr['id_objeto_diverso'] = $objeto->id_objeto_diverso;
                $dados_objetos_ocorr['quantidade']        = json_decode($dados_objetos['objetos'][$i])->quantidade;

                (new OcorrenciaObjetoDiversoController)->create($dados_objetos_ocorr);
            }
        }

        // Atualiza as armas relacionadas a ocorrência
        if ($request->has('armas')){
            $dados_armas = $request->only('armas');

            for ($i = 0; $i < count($dados_armas['armas']); $i++){
                $dados_armas_novo['tipo']       = json_decode($dados_armas['armas'][$i])->tipo;
                $dados_armas_novo['especie']    = json_decode($dados_armas['armas'][$i])->especie;
                $dados_armas_novo['fabricacao'] = json_decode($dados_armas['armas'][$i])->fabricacao;
                $dados_armas_novo['calibre']    = json_decode($dados_armas['armas'][$i])->calibre;
                $dados_armas_novo['num_serie']  = json_decode($dados_armas['armas'][$i])->num_serie;

                $arma = (new ArmaController)->create($dados_armas_novo);

                $dados_armas_ocorr['id_ocorrencia'] = $dados_ocor['id_ocorrencia'];
                $dados_armas_ocorr['id_arma']       = $arma->id_arma;

                (new OcorrenciaArmaController)->create($dados_armas_ocorr);
            }
        }

        // Atualização das drogas relacionadas a ocorrência
        if ($request->has('drogas')){
            $dados_drogas = $request->only('drogas');

            for ($i = 0; $i < count($dados_drogas['drogas']); $i++){
                $dados_drogas_novo['tipo']       = json_decode($dados_drogas['drogas'][$i])->tipo;

                $droga = (new DrogaController)->create($dados_drogas_novo);

                $dados_drogas_ocorr['id_ocorrencia'] = $dados_ocor['id_ocorrencia'];
                $dados_drogas_ocorr['id_droga']      = $droga;
                $dados_drogas_ocorr['quantidade']    = json_decode($dados_drogas['drogas'][$i])->quantidade;
                $dados_drogas_ocorr['un_medida']     = json_decode($dados_drogas['drogas'][$i])->un_medida;
                
                (new OcorrenciaDrogaController)->create($dados_drogas_ocorr);
            }
        }

        // Atualização dos animais relacionados a ocorrência
        if ($request->has('animais')){
            $dados_animais = $request->only('animais');

            for ($i = 0; $i < count($dados_animais['animais']); $i++){
                $dados_animais_novo['especie'] = json_decode($dados_animais['animais'][$i])->especie;

                $animal = (new AnimalController)->create($dados_animais_novo);

                $dados_animais_ocorr['id_ocorrencia'] = $dados_ocor['id_ocorrencia'];
                $dados_animais_ocorr['id_animal']     = $animal;
                $dados_animais_ocorr['quantidade']    = json_decode($dados_animais['animais'][$i])->quantidade;
                $dados_animais_ocorr['observacao']    = json_decode($dados_animais['animais'][$i])->outras_info;
                $dados_animais_ocorr['participacao']  = json_decode($dados_animais['animais'][$i])->participacao;

                (new OcorrenciaAnimalController)->create($dados_animais_ocorr);
            }
        }

        alert('Sucesso','Ocorrência atualizada', 'success')->showConfirmButton('Continuar');

        return route('show_Busca_Ocorrencia');
    }

    public function excluir_Ocorrencia(Request $request){
        $this->excluir_Tabelas_Intermediarias($request->id_ocorrencia);
        
        DB::table('ocorrencias_fatos_ocorrencias')
          ->where('ocorrencias_fatos_ocorrencias.id_ocorrencia', $request->id_ocorrencia)
          ->delete();

        DB::table('ocorrencias')
          ->where('ocorrencias.id_ocorrencia', $request->id_ocorrencia)
          ->delete();

        return;
    }

    public function create($dados){
        return ocorrencias::create([
            'num_protocol'         => $dados['num_protocol'],
            'data_hora'            => $dados['data_hora'],
            'endereco_cep'         => $dados['endereco_cep'],
            'endereco_num'         => $dados['endereco_numero'],
            'endereco_rua'         => $dados['endereco_rua'],
            'descricao_ocorrencia' => $dados['descricao'],
            'id_bairro'            => $dados['id_bairro'],
            'id_usuario'           => Auth::id()
        ]);
    }

    public function update(array $dados){
        $ocorrencia = ocorrencias::find($dados['id_ocorrencia']);

        $ocorrencia->update(['num_protocol'         => $dados['num_protocol'],
                             'data_hora'            => $dados['data_hora'],
                             'endereco_cep'         => $dados['endereco_cep'],
                             'endereco_num'         => $dados['endereco_numero'],
                             'endereco_rua'         => $dados['endereco_rua'],
                             'descricao_ocorrencia' => $dados['descricao'],
                             'id_bairro'            => $dados['id_bairro'],
                            ]);

        return $ocorrencia;
    }

    public function get_Endereco($id_bairro){
        $bairro = DB::table('bairros')
                    ->where('id_bairro', $id_bairro)
                    ->get();

        $cidade = DB::table('cidades')
                ->where('id_cidade', $bairro[0]->id_cidade)
                ->get();

        $estado = DB::table('estados')
                ->select('sigla')
                ->where('id_estado', $cidade[0]->id_estado)
                ->get(); 

        $endereco = collect([
            'bairro' => $bairro[0]->nome,
            'cidade' => $cidade[0]->nome,
            'estado' => $estado[0]->sigla 
        ]);

        return $endereco;
    }

    public function salvar_Endereco($dados_estado, $dados_cidade, $dados_bairro){
        $id_estado = (new EstadoController)->create($dados_estado);
        $dados_cidade['id_estado'] = $id_estado;

        $id_cidade = (new CidadeController)->create($dados_cidade);
        $dados_bairro['id_cidade'] = $id_cidade;

        $id_bairro = (new BairroController)->create($dados_bairro);

        return $id_bairro;
    }

    public function excluir_Tabelas_Intermediarias($id_ocorrencia){
        $ocorrencia = DB::table('ocorrencias')
                        ->select('ocorrencias.id_ocorrencia_extraida')
                        ->where('ocorrencias.id_ocorrencia', $id_ocorrencia)
                        ->first();

        // Fatos Ocorrências
        DB::table('ocorrencias_fatos_ocorrencias')
          ->where('ocorrencias_fatos_ocorrencias.id_ocorrencia', $id_ocorrencia)
          ->delete();
        
        // Pessoas
        $ocorrencias_pessoas = DB::table('ocorrencias_pessoas')
                                 ->select('id_ocorrencia_pessoa')
                                 ->where('id_ocorrencia', $id_ocorrencia)
                                 ->get();
        
        foreach ($ocorrencias_pessoas as $ocorrencia_pessoa){
            DB::table('participacao_pessoas_fatos')
              ->where('id_ocorrencia_pessoa', $ocorrencia_pessoa->id_ocorrencia_pessoa)
              ->delete();
        }

        DB::table('ocorrencias_pessoas')
          ->where('ocorrencias_pessoas.id_ocorrencia', $id_ocorrencia)
          ->delete();
        
        // Veículos
        DB::table('ocorrencias_veiculos')
          ->where('id_ocorrencia', $id_ocorrencia)
          ->delete();
        
        // Objetos
        $objetos = DB::table('ocorrencias_objetos_diversos')
                     ->select('ocorrencias_objetos_diversos.id_objeto_diverso')
                     ->where('ocorrencias_objetos_diversos.id_ocorrencia', $id_ocorrencia)
                     ->get();

        DB::table('ocorrencias_objetos_diversos')
          ->where('ocorrencias_objetos_diversos.id_ocorrencia', $id_ocorrencia)
          ->delete();

        foreach ($objetos as $objeto) {
            if (DB::table('ocorrencias_extraidas_objetos_diversos')->where('id_objeto_diverso', $objeto->id_objeto_diverso)->doesntExist()){
                DB::table('objetos_diversos')
                  ->where('objetos_diversos.id_objeto_diverso', $objeto->id_objeto_diverso)
                  ->delete();
            }
        }

        // Armas
        $armas = DB::table('ocorrencias_armas')
                   ->select('ocorrencias_armas.id_arma')
                   ->where('ocorrencias_armas.id_ocorrencia', $id_ocorrencia)
                   ->get();
        
        // Armas
        DB::table('ocorrencias_armas')
          ->where('ocorrencias_armas.id_ocorrencia', $id_ocorrencia)
          ->delete();

        foreach ($armas as $arma) {
            if (DB::table('ocorrencias_extraidas_armas')->where('id_arma', $arma->id_arma)->doesntExist()){
                DB::table('armas')
                  ->where('armas.id_arma', $arma->id_arma)
                  ->delete();
            }
        }

        // Drogas
        DB::table('ocorrencias_drogas')
          ->where('ocorrencias_drogas.id_ocorrencia', $id_ocorrencia)
          ->delete();
        
        // Animais
        DB::table('ocorrencias_animais')
          ->where('ocorrencias_animais.id_ocorrencia', $id_ocorrencia)
          ->delete();  
    }
}
