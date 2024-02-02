<?php

namespace App\Http\Controllers;

use App\Models\ocorrencias;
use App\Models\ocorrencias_extraidas;   
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class OcorrenciaExtraidaController extends Controller
{
    public function show_Importar_Ocorrencia(Request $request){
        $num_protocol = $request->input_num_protocol;
        $data_inicial = $request->data_inicial_ocorr;
        $data_final   = $request->data_final_ocorr;
        $descricao    = $request->input_descricao;
        $revisado     = $request->input_adicionado;

        // --------------------------------- Filtros ---------------------------------
        $query = DB::table('ocorrencias_extraidas')
                   ->select('id_ocorrencia_extraida','num_protocol', 'descricao_ocorrencia', DB::raw('DATE_FORMAT(ocorrencias_extraidas.data_hora, "%d/%m/%Y %H:%i:%s") as data_hora'), 'revisado');

        if ($request->input_num_protocol != null){
            $query->where('ocorrencias_extraidas.num_protocol', $num_protocol);
        }

        if ($request->data_inicial_ocorr != null){
            $query->whereDate('ocorrencias_extraidas.data_hora', '>=', $data_inicial);
        }

        if ($request->data_final_ocorr != null){
            $query->whereDate('ocorrencias_extraidas.data_hora', '<=', $data_final);
        }

        if ($request->input_descricao != null){
            $query->where('ocorrencias_extraidas.descricao_ocorrencia', 'like', '%' . $descricao . '%');
        }

        if ($revisado != "Todos"){
            if ($request->input_adicionado == "Adicionado"){
                $query->where('ocorrencias_extraidas.revisado', 'S');
            }
            if ($request->input_adicionado == "Não adicionado"){
                $query->where('ocorrencias_extraidas.revisado', 'N');
            }
            
        }

        $query->orderByDesc('ocorrencias_extraidas.id_ocorrencia_extraida');

        $ocorrencias_extraidas = $query->paginate(10);

        return view('ocorrencia.importar_ocorrencia', compact('ocorrencias_extraidas', 'num_protocol', 'data_inicial', 'data_final',
                                                              'data_final', 'descricao', 'revisado'));
    }

    public function show_Revisar_Ocorrencia($id_ocorrencia_extraida){
        $ocorrencia_extraida = DB::table('ocorrencias_extraidas')
                                 ->select('ocorrencias_extraidas.id_ocorrencia_extraida', 'ocorrencias_extraidas.num_protocol', 'ocorrencias_extraidas.data_hora',
                                          'ocorrencias_extraidas.descricao_inicial', 'ocorrencias_extraidas.descricao_ocorrencia', 'ocorrencias_extraidas.possui_envolvidos',
                                          'ocorrencias_extraidas.possui_veiculos', 'ocorrencias_extraidas.possui_armas', 'ocorrencias_extraidas.possui_drogas', 'ocorrencias_extraidas.possui_objetos',
                                          'ocorrencias_extraidas.possui_animais', 'ocorrencias_extraidas.pdf_caminho_servidor', 'ocorrencias_extraidas.endereco_cep',
                                          'ocorrencias_extraidas.endereco_rua', 'ocorrencias_extraidas.endereco_num', 'bairros.nome as bairro',
                                          'cidades.nome as cidade', 'estados.sigla as estado', 'ocorrencias_extraidas.revisado')
                                 ->leftJoin('bairros', 'ocorrencias_extraidas.id_bairro', 'bairros.id_bairro')
                                 ->leftJoin('cidades', 'bairros.id_cidade', 'cidades.id_cidade')
                                 ->leftJoin('estados', 'cidades.id_estado', 'estados.id_estado')
                                 ->where('id_ocorrencia_extraida', $id_ocorrencia_extraida)
                                 ->get();
        
        $pessoas = DB::table('ocorrencias_extraidas_pessoas')
                     ->select('pessoas.id_pessoa', 'pessoas.nome', 'pessoas.RG_CPF', DB::raw('GROUP_CONCAT(CONCAT(participacao_pessoas_extraidas_fatos.participacao, ":", fatos_ocorrencias.natureza) SEPARATOR "|") AS participacao'))
                     ->where('id_ocorrencia_extraida', $id_ocorrencia_extraida)
                     ->leftJoin('pessoas', 'ocorrencias_extraidas_pessoas.id_pessoa', 'pessoas.id_pessoa')
                     ->leftJoin('participacao_pessoas_extraidas_fatos', 'ocorrencias_extraidas_pessoas.id_ocorrencia_extraida_pessoa', 'participacao_pessoas_extraidas_fatos.id_ocorrencia_extraida_pessoa')
                     ->leftJoin('fatos_ocorrencias', 'participacao_pessoas_extraidas_fatos.id_fato_ocorrencia', 'fatos_ocorrencias.id_fato_ocorrencia')
                     ->groupBy('pessoas.id_pessoa', 'pessoas.nome', 'pessoas.RG_CPF')
                     ->get();

        $veiculos = DB::table('ocorrencias_extraidas_veiculos')
                        ->select('veiculos.id_veiculo', 'veiculos.placa', 'veiculos.cor', 'marcas_veiculos.marca', 'ocorrencias_extraidas_veiculos.participacao')
                        ->where('id_ocorrencia_extraida', $id_ocorrencia_extraida)
                        ->leftJoin('veiculos', 'ocorrencias_extraidas_veiculos.id_veiculo', 'veiculos.id_veiculo')
                        ->leftJoin('marcas_veiculos', 'veiculos.id_marca_veiculo', 'marcas_veiculos.id_marca_veiculo')
                        ->get();
        
        $objetos_diversos = DB::table('ocorrencias_extraidas_objetos_diversos')
                              ->select('objetos_diversos.*', 'ocorrencias_extraidas_objetos_diversos.quantidade', 'tipos_objetos.objeto')
                              ->where('id_ocorrencia_extraida', $id_ocorrencia_extraida)
                              ->leftJoin('objetos_diversos', 'ocorrencias_extraidas_objetos_diversos.id_objeto_diverso', 'objetos_diversos.id_objeto_diverso')
                              ->leftJoin('tipos_objetos', 'objetos_diversos.id_tipo_objeto', 'tipos_objetos.id_tipo_objeto')
                              ->get();
        
        $tipos_objetos = DB::table('tipos_objetos')
                           ->select('objeto')
                           ->get();
        
        $armas = DB::table('ocorrencias_extraidas_armas')
                   ->select('armas.*')
                   ->where('id_ocorrencia_extraida', $id_ocorrencia_extraida)
                   ->leftJoin('armas', 'ocorrencias_extraidas_armas.id_arma', 'armas.id_arma')
                   ->get();
        
        $drogas = DB::table('ocorrencias_extraidas_drogas')
                    ->select('drogas.tipo', 'ocorrencias_extraidas_drogas.quantidade', 'ocorrencias_extraidas_drogas.un_medida')
                    ->where('id_ocorrencia_extraida', $id_ocorrencia_extraida)
                    ->leftJoin('drogas', 'ocorrencias_extraidas_drogas.id_droga', 'drogas.id_droga')
                    ->get();

        $animais = DB::table('ocorrencias_extraidas_animais')
                     ->select('animais.especie', 'ocorrencias_extraidas_animais.quantidade', 
                              'ocorrencias_extraidas_animais.observacao', 'ocorrencias_extraidas_animais.participacao')
                     ->where('id_ocorrencia_extraida', $id_ocorrencia_extraida)
                     ->leftJoin('animais', 'ocorrencias_extraidas_animais.id_animal', 'animais.id_animal')
                     ->get();
        
        $ocr_ext_fatos_ocorrencias = DB::table('ocorrencias_extraidas_fatos_ocorrencias')
                                       ->select('ocorrencias_extraidas_fatos_ocorrencias.id_fato_ocorrencia')
                                       ->where('ocorrencias_extraidas_fatos_ocorrencias.id_ocorrencia_extraida', $id_ocorrencia_extraida)
                                       ->get();
        
        $fatos_ocorrencias = DB::table('fatos_ocorrencias')
                               ->select('fatos_ocorrencias.natureza', 'fatos_ocorrencias.id_fato_ocorrencia')
                               ->get(); 
        

        return view('ocorrencia.revisar_ocorrencia', compact('ocorrencia_extraida', 'pessoas', 'veiculos', 'objetos_diversos', 'tipos_objetos',
                                                             'armas', 'drogas', 'animais', 'ocr_ext_fatos_ocorrencias', 'fatos_ocorrencias'));
    }

    public function nova_Ocorrencia_Revisada(Request $request){
        $validator = Validator::make($request->all(), [
            'num_protocol'      => ['required'],
            'data_hora'         => ['required'],
            'tipo_ocorrencia'   => ['required'],
            'endereco_estado'   => ['required'],
            'endereco_cidade'   => ['required'],
            'endereco_bairro'   => ['required'],
            'descricao_inicial' => ['required'],
            'descricao'         => ['required']
        ]);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }

        // ----------------------------------------- Seção de cadastro da tabela ocorrencias_extraidas ----------------------------------------- //
        $dados_ocorrencias_extraidas = request()->only('num_protocol', 'data_hora', 'endereco_cep',  
                                                       'endereco_rua', 'endereco_numero', 'descricao_inicial',
                                                       'descricao', 'id_ocorrencia_extraida', 'revisado');

        // Cadastro de endereço
        $dados_estado_ocorr = request()->only('endereco_estado');
        $dados_cidade_ocorr = request()->only('endereco_cidade');
        $dados_bairro_ocorr = request()->only('endereco_bairro');

        $dados_ocorrencias_extraidas['id_bairro'] = (new OcorrenciaController)->salvar_Endereco($dados_estado_ocorr, $dados_cidade_ocorr, $dados_bairro_ocorr);

        $this->update($dados_ocorrencias_extraidas);

        // ---------------------------------------------- Seção de cadastro da tabela ocorrencias ---------------------------------------------- //

        $dados_ocorrencias['num_protocol']           = $dados_ocorrencias_extraidas['num_protocol'];
        $dados_ocorrencias['data_hora']              = $dados_ocorrencias_extraidas['data_hora'];
        $dados_ocorrencias['endereco_cep']           = $dados_ocorrencias_extraidas['endereco_cep'];
        $dados_ocorrencias['endereco_rua']           = $dados_ocorrencias_extraidas['endereco_rua'];
        $dados_ocorrencias['endereco_num']           = $dados_ocorrencias_extraidas['endereco_numero'];
        $dados_ocorrencias['descricao_inicial']      = $dados_ocorrencias_extraidas['descricao_inicial'];
        $dados_ocorrencias['descricao_ocorrencia']   = $dados_ocorrencias_extraidas['descricao'];
        $dados_ocorrencias['id_ocorrencia_extraida'] = $dados_ocorrencias_extraidas['id_ocorrencia_extraida'];
        $dados_ocorrencias['id_bairro']              = $dados_ocorrencias_extraidas['id_bairro'];

        $ocorrencias = $this->create_ocorrencia($dados_ocorrencias);

        // --------------------- Seção de cadastro das informações extras das tabelas ocorrencias_extraidas e ocorrencias --------------------- //

        // Cadastro de fatos relacionados a ocorrência
        DB::table('ocorrencias_extraidas_fatos_ocorrencias')
          ->where('ocorrencias_extraidas_fatos_ocorrencias.id_ocorrencia_extraida', $dados_ocorrencias_extraidas['id_ocorrencia_extraida'])
          ->delete();

        $fatos_ocorr = explode(',', request()->only('tipo_ocorrencia')['tipo_ocorrencia']);

        foreach ($fatos_ocorr as $fato_ocorr){
            $dados_fatos_ocorrencia['id_ocorrencia_extraida'] = $ocorrencias->id_ocorrencia_extraida;
            $dados_fatos_ocorrencia['id_fato_ocorrencia']     = $fato_ocorr;

            (new OcorrenciaExtraidaFatoOcorrenciaController)->create($dados_fatos_ocorrencia);

            $dados_fatos_ocorrencia['id_ocorrencia'] = $ocorrencias->id_ocorrencia;

            (new OcorrenciaFatoOcorrenciaController)->create($dados_fatos_ocorrencia);
        }

        // Cadastro de envolvidos relacionados a ocorrência
        if ($request->has('envolvidos')){
            $dados_pessoas = $request->only('envolvidos');
            
            $ocorrencias_extraidas_pessoas = DB::table('ocorrencias_extraidas_pessoas')
                                               ->select('ocorrencias_extraidas_pessoas.id_ocorrencia_extraida_pessoa')
                                               ->where('id_ocorrencia_extraida', $ocorrencias->id_ocorrencia_extraida)
                                               ->get();

            foreach ($ocorrencias_extraidas_pessoas as $ocorrencia_extraida_pessoa){
                DB::table('participacao_pessoas_extraidas_fatos')
                  ->where('id_ocorrencia_extraida_pessoa', $ocorrencia_extraida_pessoa->id_ocorrencia_extraida_pessoa)
                  ->delete();
            }

            DB::table('ocorrencias_extraidas_pessoas')
              ->where('id_ocorrencia_extraida', $ocorrencias->id_ocorrencia_extraida)
              ->delete();

            for ($i = 0; $i < count($dados_pessoas['envolvidos']); $i++){
                $dados_pessoas_ocorr['id_ocorrencia_extraida'] = $request->id_ocorrencia_extraida;
                $dados_pessoas_ocorr['id_pessoa']              = json_decode($dados_pessoas['envolvidos'][$i])->id_envolvido;

                $ocorrencia_extraida_pessoa = (new OcorrenciaExtraidaPessoaController)->create($dados_pessoas_ocorr);

                $dados_pessoas_ocorr['id_ocorrencia'] = $ocorrencias->id_ocorrencia;

                $ocorrencia_pessoa = (new OcorrenciaPessoaController)->create($dados_pessoas_ocorr);

                $participacoes = explode('|', json_decode($dados_pessoas['envolvidos'][$i])->participacao);

                if ($participacoes[0] != ""){
                    foreach ($participacoes as $participacao){
                        $fato_participacao = explode(':', $participacao);
                        
                        $fato = DB::table('fatos_ocorrencias')
                                    ->select('fatos_ocorrencias.id_fato_ocorrencia')
                                    ->where('fatos_ocorrencias.natureza', trim($fato_participacao[1]))
                                    ->first();
    
                        $participacao_pessoa_fato['id_ocorrencia_extraida_pessoa'] = $ocorrencia_extraida_pessoa->id_ocorrencia_extraida_pessoa;
                        $participacao_pessoa_fato['id_fato_ocorrencia']            = $fato->id_fato_ocorrencia;    
                        $participacao_pessoa_fato['participacao']                  = trim($fato_participacao[0]);
                        
                        (new ParticipacaoPessoaExtraidaFatoController)->create($participacao_pessoa_fato);
    
                        $participacao_pessoa_fato['id_ocorrencia_pessoa'] = $ocorrencia_pessoa->id_ocorrencia_pessoa;
    
                        (new ParticipacaoPessoaFatoController)->create($participacao_pessoa_fato);
                    }
                }
            }
        }
        
        // Cadastro de veiculos relacionados a ocorrência
        DB::table('ocorrencias_extraidas_veiculos')
          ->where('id_ocorrencia_extraida', $ocorrencias->id_ocorrencia_extraida)
          ->delete();

        if ($request->has('veiculos')){
            $dados_veiculos = $request->only('veiculos');

            for ($i = 0; $i < count($dados_veiculos['veiculos']); $i++){
                $dados_veiculos_ocorr['id_ocorrencia_extraida'] = $request->id_ocorrencia_extraida;
                $dados_veiculos_ocorr['id_veiculo']             = json_decode($dados_veiculos['veiculos'][$i])->id_veiculo;
                $dados_veiculos_ocorr['participacao']           = json_decode($dados_veiculos['veiculos'][$i])->participacao;

                (new OcorrenciaExtraidaVeiculoController)->create($dados_veiculos_ocorr);

                $dados_veiculos_ocorr['id_ocorrencia'] = $ocorrencias->id_ocorrencia;

                (new OcorrenciaVeiculoController)->create($dados_veiculos_ocorr);
            }
        }

        // Cadastro de objetos relacionados a ocorrência
        $objetos = DB::table('ocorrencias_extraidas_objetos_diversos')
                         ->select('ocorrencias_extraidas_objetos_diversos.id_objeto_diverso')
                         ->where('ocorrencias_extraidas_objetos_diversos.id_ocorrencia_extraida', $request->id_ocorrencia_extraida)
                         ->get();
                
        DB::table('ocorrencias_extraidas_objetos_diversos')
          ->where('ocorrencias_extraidas_objetos_diversos.id_ocorrencia_extraida', $request->id_ocorrencia_extraida)
          ->delete();
        
        foreach ($objetos as $objeto) {
            DB::table('objetos_diversos')
              ->where('objetos_diversos.id_objeto_diverso', $objeto->id_objeto_diverso)
              ->delete();
        }

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

                $dados_objetos_ocorr['id_ocorrencia_extraida'] = $request->id_ocorrencia_extraida;
                $dados_objetos_ocorr['id_objeto_diverso']      = $objeto->id_objeto_diverso;
                $dados_objetos_ocorr['quantidade']             = json_decode($dados_objetos['objetos'][$i])->quantidade;
                
                (new OcorrenciaExtraidaObjetoDiversoController)->create($dados_objetos_ocorr);

                $dados_objetos_ocorr['id_ocorrencia'] = $ocorrencias->id_ocorrencia;

                (new OcorrenciaObjetoDiversoController)->create($dados_objetos_ocorr);
            }
        }

        // Cadastro de armas relacionados a ocorrência
        $armas = DB::table('ocorrencias_extraidas_armas')
                   ->select('ocorrencias_extraidas_armas.id_arma')
                   ->where('ocorrencias_extraidas_armas.id_ocorrencia_extraida', $request->id_ocorrencia_extraida)
                   ->get();

        DB::table('ocorrencias_extraidas_armas')
          ->where('ocorrencias_extraidas_armas.id_ocorrencia_extraida', $request->id_ocorrencia_extraida)
          ->delete();

        foreach ($armas as $arma) {
            DB::table('armas')
              ->where('armas.id_arma', $arma->id_arma)
              ->delete();
        }
        
        if ($request->has('armas')){
            $dados_armas = $request->only('armas');

            for ($i = 0; $i < count($dados_armas['armas']); $i++){
                $dados_armas_novo['tipo']       = json_decode($dados_armas['armas'][$i])->tipo;
                $dados_armas_novo['especie']    = json_decode($dados_armas['armas'][$i])->especie;
                $dados_armas_novo['fabricacao'] = json_decode($dados_armas['armas'][$i])->fabricacao;
                $dados_armas_novo['calibre']    = json_decode($dados_armas['armas'][$i])->calibre;
                $dados_armas_novo['num_serie']  = json_decode($dados_armas['armas'][$i])->num_serie;

                $arma = (new ArmaController)->create($dados_armas_novo);

                $dados_armas_ocorr['id_ocorrencia_extraida'] = $request->id_ocorrencia_extraida;
                $dados_armas_ocorr['id_arma']                = $arma->id_arma;
                
                (new OcorrenciaExtraidaArmaController)->create($dados_armas_ocorr);

                $dados_armas_ocorr['id_ocorrencia'] = $ocorrencias->id_ocorrencia;

                (new OcorrenciaArmaController)->create($dados_armas_ocorr);
            }
        }

        // Cadastro de drogas relacionados a ocorrência
        DB::table('ocorrencias_extraidas_drogas')
          ->where('ocorrencias_extraidas_drogas.id_ocorrencia_extraida', $request->id_ocorrencia_extraida)
          ->delete();

        if ($request->has('drogas')){
            $dados_drogas = $request->only('drogas');

            for ($i = 0; $i < count($dados_drogas['drogas']); $i++){
                $dados_drogas_novo['tipo']       = json_decode($dados_drogas['drogas'][$i])->tipo;

                $droga = (new DrogaController)->create($dados_drogas_novo);

                $dados_drogas_ocorr['id_ocorrencia_extraida'] = $request->id_ocorrencia_extraida;
                $dados_drogas_ocorr['id_droga']               = $droga;
                $dados_drogas_ocorr['quantidade']             = json_decode($dados_drogas['drogas'][$i])->quantidade;
                $dados_drogas_ocorr['un_medida']              = json_decode($dados_drogas['drogas'][$i])->un_medida;
                
                (new OcorrenciaExtraidaDrogaController)->create($dados_drogas_ocorr);

                $dados_drogas_ocorr['id_ocorrencia'] = $ocorrencias->id_ocorrencia;

                (new OcorrenciaDrogaController)->create($dados_drogas_ocorr);
            }
        }

        // Cadastro de animais relacionados a ocorrência
        DB::table('ocorrencias_extraidas_animais')
          ->where('ocorrencias_extraidas_animais.id_ocorrencia_extraida', $request->id_ocorrencia_extraida)
          ->delete();  
        
        if ($request->has('animais')){
            $dados_animais = $request->only('animais');

            for ($i = 0; $i < count($dados_animais['animais']); $i++){
                $dados_animais_novo['especie'] = json_decode($dados_animais['animais'][$i])->especie;

                $animal = (new AnimalController)->create($dados_animais_novo);
                
                $dados_animais_ocorr['id_ocorrencia_extraida'] = $request->id_ocorrencia_extraida;
                $dados_animais_ocorr['id_animal']              = $animal;
                $dados_animais_ocorr['quantidade']             = json_decode($dados_animais['animais'][$i])->quantidade;
                $dados_animais_ocorr['observacao']             = json_decode($dados_animais['animais'][$i])->outras_info;
                $dados_animais_ocorr['participacao']           = json_decode($dados_animais['animais'][$i])->participacao;
                
                (new OcorrenciaExtraidaAnimalController)->create($dados_animais_ocorr);

                $dados_animais_ocorr['id_ocorrencia'] = $ocorrencias->id_ocorrencia;

                (new OcorrenciaAnimalController)->create($dados_animais_ocorr);
            }
        }

        return route("show_Importar_Ocorrencia");
    }

    public function excluir_Ocorrencia_Extraida(Request $request){
        $ocorrencia_extraida = DB::table('ocorrencias_extraidas')
                                 ->select('ocorrencias_extraidas.id_ocorrencia_extraida', 'ocorrencias_extraidas.possui_veiculos',
                                        'ocorrencias_extraidas.possui_envolvidos', 'ocorrencias_extraidas.possui_armas',
                                        'ocorrencias_extraidas.possui_drogas', 'ocorrencias_extraidas.possui_objetos',
                                        'ocorrencias_extraidas.possui_animais', 'ocorrencias_extraidas.pdf_caminho_servidor',
                                        'ocorrencias_extraidas.revisado')
                                 ->where('ocorrencias_extraidas.id_ocorrencia_extraida', $request->id_ocorrencia_extraida)
                                 ->first();
        
        DB::table('ocorrencias_extraidas_fatos_ocorrencias')
          ->where('id_ocorrencia_extraida', $request->id_ocorrencia_extraida)
          ->delete();

        if ($ocorrencia_extraida->revisado == 'N') {
            if ($ocorrencia_extraida->possui_envolvidos == "S"){
                $ocorrencias_extraidas_pessoas = DB::table('ocorrencias_extraidas_pessoas')
                                                   ->select('ocorrencias_extraidas_pessoas.id_ocorrencia_extraida_pessoa')
                                                   ->where('ocorrencias_extraidas_pessoas.id_ocorrencia_extraida', $request->id_ocorrencia_extraida)
                                                   ->get();
                
                foreach ($ocorrencias_extraidas_pessoas as $ocorrencia_extraida_pessoa){
                    DB::table('participacao_pessoas_extraidas_fatos')
                      ->where('participacao_pessoas_extraidas_fatos.id_ocorrencia_extraida_pessoa', $ocorrencia_extraida_pessoa->id_ocorrencia_extraida_pessoa)
                      ->delete();
                }

                DB::table('ocorrencias_extraidas_pessoas')
                  ->where('ocorrencias_extraidas_pessoas.id_ocorrencia_extraida', $request->id_ocorrencia_extraida)
                  ->delete();
            }
    
            if ($ocorrencia_extraida->possui_veiculos == "S"){
                DB::table('ocorrencias_extraidas_veiculos')
                  ->where('ocorrencias_extraidas_veiculos.id_ocorrencia_extraida', $request->id_ocorrencia_extraida)
                  ->delete();
            }
    
            if ($ocorrencia_extraida->possui_armas == "S"){
                $armas = DB::table('ocorrencias_extraidas_armas')
                           ->select('ocorrencias_extraidas_armas.id_arma')
                           ->where('ocorrencias_extraidas_armas.id_ocorrencia_extraida', $request->id_ocorrencia_extraida)
                           ->get();
                
                DB::table('ocorrencias_extraidas_armas')
                  ->where('ocorrencias_extraidas_armas.id_ocorrencia_extraida', $request->id_ocorrencia_extraida)
                  ->delete();
    
                foreach ($armas as $arma) {
                    DB::table('armas')
                      ->where('armas.id_arma', $arma->id_arma)
                      ->delete();
                }
            }
    
            if ($ocorrencia_extraida->possui_drogas == "S"){
                DB::table('ocorrencias_extraidas_drogas')
                  ->where('ocorrencias_extraidas_drogas.id_ocorrencia_extraida', $request->id_ocorrencia_extraida)
                  ->delete();
            }
    
            if ($ocorrencia_extraida->possui_objetos == "S"){
                $objetos = DB::table('ocorrencias_extraidas_objetos_diversos')
                             ->select('ocorrencias_extraidas_objetos_diversos.id_objeto_diverso')
                             ->where('ocorrencias_extraidas_objetos_diversos.id_ocorrencia_extraida', $request->id_ocorrencia_extraida)
                             ->get();
                
                DB::table('ocorrencias_extraidas_objetos_diversos')
                  ->where('ocorrencias_extraidas_objetos_diversos.id_ocorrencia_extraida', $request->id_ocorrencia_extraida)
                  ->delete();
                
                foreach ($objetos as $objeto) {
                    DB::table('objetos_diversos')
                      ->where('objetos_diversos.id_objeto_diverso', $objeto->id_objeto_diverso)
                      ->delete();
                }
            }
    
            if ($ocorrencia_extraida->possui_animais == "S"){
                $animais = DB::table('ocorrencias_extraidas_animais')
                             ->select('ocorrencias_extraidas_animais.id_animal')
                             ->where('ocorrencias_extraidas_animais.id_ocorrencia_extraida', $request->id_ocorrencia_extraida)
                             ->get();
    
                DB::table('ocorrencias_extraidas_animais')
                  ->where('ocorrencias_extraidas_animais.id_ocorrencia_extraida', $request->id_ocorrencia_extraida)
                  ->delete();  
                
                foreach ($animais as $animal) {
                    DB::table('animais')
                      ->where('animais.id_animal', $animal->id_animal)
                      ->delete();
                }
            }
    
            File::delete(public_path() . '\\uploads\\pdf\\' . basename($ocorrencia_extraida->pdf_caminho_servidor));
    
            DB::table('ocorrencias_extraidas')
              ->where('ocorrencias_extraidas.id_ocorrencia_extraida', $request->id_ocorrencia_extraida)
              ->delete();  
            
            alert('Sucesso','Ocorrência importada excluída', 'success')->showConfirmButton('Continuar');
        } else {
            alert('Erro!','Não é possível excluir uma ocorrência já adicionada', 'warning')->showConfirmButton('Continuar');          
        }
    }

    public function importar_Ocorrencia(Request $request){
        $duplicated_pdf   = ""; 
        $fato_inexistente = "";
        $count_fatos_inexistentes = 0;

        $request->validate([
            'files.*' => ['mimes:pdf']
        ]);

        $ocorrencias = "";

        if ($request->hasFile('files')){
            foreach ($request->file('files') as $file) {
                $name = time().'_'.$file->getClientOriginalName();

                $file->move(public_path('uploads\pdf'), $name );
            }           
        }
        
        $process = new Process(["python", resource_path("\\python\\extracao_PDF.py")],
                                null, ['SYSTEMROOT' => getenv('SYSTEMROOT'), 'PATH' => getenv("PATH")]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $ocorrencias = json_decode($process->getOutput()); 

        foreach ($ocorrencias as $key => $value) {
            $nome_pdf           = basename($value->PDF_original);
            $caminho_servidor   = URL::to('/') . '/uploads/pdf/' . $nome_pdf;

            if (DB::table("ocorrencias_extraidas")->where("num_protocol", $value->num_protocol)->doesntExist()){
                $date_time = DateTime::createFromFormat('d/m/Y H:i:s', $value->data_hora);

                # Endereço da ocorrência extraída

                $dados_bairro['endereco_bairro'] = preg_replace('/\s+/', ' ', $value->endereco->endereco_bairro);
                $dados_cidade['endereco_cidade'] = preg_replace('/\s+/', ' ', $value->endereco->endereco_cidade);
                $dados_estado['endereco_estado'] = preg_replace('/\s+/', ' ', $value->endereco->endereco_estado);

                $dados_ocorrencia['id_bairro'] = (new OcorrenciaController)->salvar_Endereco($dados_estado, $dados_cidade, $dados_bairro);
            
                $dados_ocorrencia['endereco_cep'] = $value->endereco->endereco_cep;
                $dados_ocorrencia['endereco_rua'] = $value->endereco->endereco_rua;

                if (strpos($value->endereco->endereco_num, 'nº S/N') == false){
                    $dados_ocorrencia['endereco_numero'] = "";
                } else {
                    $dados_ocorrencia['endereco_numero'] = $value->endereco->endereco_num;
                }

                # Outros dados da ocorrência extraída
                $dados_ocorrencia['num_protocol']         = $value->num_protocol;
                $dados_ocorrencia['data_hora']            = $date_time; 
                $dados_ocorrencia['descricao_inicial']    = $value->desc_inicial;
                $dados_ocorrencia['descricao']            = $value->descricao;
                $dados_ocorrencia['possui_envolvidos']    = $value->possui_envolvidos;
                $dados_ocorrencia['possui_veiculos']      = $value->possui_veiculos;
                $dados_ocorrencia['possui_armas']         = $value->possui_armas;
                $dados_ocorrencia['possui_drogas']        = $value->possui_drogas;
                $dados_ocorrencia['possui_objetos']       = $value->possui_objetos;
                $dados_ocorrencia['possui_animais']       = $value->possui_animais;
                $dados_ocorrencia['pdf_caminho_servidor'] = $caminho_servidor;
                $dados_ocorrencia['revisado']             = "N";

                $ocorrencia_extraida = $this->create($dados_ocorrencia);

                foreach ($value->fatos as $fato) {
                    $fato_ocorrencia = DB::table('fatos_ocorrencias')->where('natureza', trim($fato))->first();

                    if ($fato_ocorrencia != null){
                        $dado_fato['id_ocorrencia_extraida'] = $ocorrencia_extraida->id_ocorrencia_extraida;
                        $dado_fato['id_fato_ocorrencia']     = $fato_ocorrencia->id_fato_ocorrencia;

                        (new OcorrenciaExtraidaFatoOcorrenciaController)->create($dado_fato);
                    } else {
                        $fato_inexistente .= trim($fato) . ',';
                        $count_fatos_inexistentes++;
                    }
                }

                foreach ($value->envolvidos as $envolvido){
                    if ($envolvido->RG == ''){
                        $dado_pessoa['CPF_RG'] = $envolvido->CPF;
                    } else {
                        $dado_pessoa['CPF_RG'] = $envolvido->RG;
                    }

                    if ($dado_pessoa['CPF_RG'] != ''){
                        $pessoa = DB::table('pessoas')->select('id_pessoa')->where('RG_CPF', $dado_pessoa['CPF_RG'])->first();
                    } else {
                        $pessoa = DB::table('pessoas')->select('id_pessoa')->where('nome', preg_replace('/\s+/', ' ', $envolvido->nome))->first();
                    }

                    if ($pessoa == null){
                        $dado_pessoa['nome']              = preg_replace('/\s+/', ' ', $envolvido->nome);
                        $dado_pessoa['data_nascimento']   = Carbon::createFromFormat('d/m/Y', $envolvido->data_nascimento)->format('Y-m-d');
                        $dado_pessoa['telefone']          = '';
                        $dado_pessoa['alcunha']           = '';
                        $dado_pessoa['observacao_pessoa'] = '';

                        $estado['endereco_estado'] = $envolvido->estado; 

                        $id_estado = (new EstadoController)->create($estado);

                        $dado_pessoa['id_estado'] = $id_estado;

                        $pessoa = (new PessoaController)->create($dado_pessoa);
                    }

                    $dado_pessoa['id_ocorrencia_extraida'] = $ocorrencia_extraida->id_ocorrencia_extraida;
                    $dado_pessoa['id_pessoa']              = $pessoa->id_pessoa;
                    
                    $participacoes = explode('|', $envolvido->participacao);

                    array_shift($participacoes);

                    $ocorrencia_extraida_pessoa = (new OcorrenciaExtraidaPessoaController)->create($dado_pessoa);

                    if ($participacoes[0] != ""){
                        foreach ($participacoes as $participacao){
                            $fato_participacao = explode(':', $participacao);

                            $fato = DB::table('fatos_ocorrencias')
                                      ->select('fatos_ocorrencias.id_fato_ocorrencia')
                                      ->where('fatos_ocorrencias.natureza', preg_replace('/\s+/', ' ',trim($fato_participacao[1])))
                                      ->first();
                            
                            if ($fato) {
                                $participacao_pessoa_extraida_fato['id_ocorrencia_extraida_pessoa'] = $ocorrencia_extraida_pessoa->id_ocorrencia_extraida_pessoa;
                                $participacao_pessoa_extraida_fato['id_fato_ocorrencia']            = $fato->id_fato_ocorrencia;    
                                $participacao_pessoa_extraida_fato['participacao']                  = trim($fato_participacao[0]);
                                
                                (new ParticipacaoPessoaExtraidaFatoController)->create($participacao_pessoa_extraida_fato);
                            }
                        }
                    }
                }
                
                foreach ($value->veiculos as $veiculo){
                    $veiculo_extraido = DB::table('veiculos')->select('id_veiculo')->where('placa', $veiculo->placa)->first();

                    if ($veiculo_extraido == null){
                        $dado_veiculo['placa']                = $veiculo->placa;
                        $dado_veiculo['chassi']               = $veiculo->chassi;
                        $dado_veiculo['renavam']              = $veiculo->renavam;
                        $dado_veiculo['marca_modelo_veiculo'] = $veiculo->marca;
                        $dado_veiculo['cor_veiculo']          = $veiculo->cor;

                        $veiculo_extraido = (new VeiculoController)->create($dado_veiculo);
                    }

                    $dado_veiculo['id_ocorrencia_extraida'] = $ocorrencia_extraida->id_ocorrencia_extraida;
                    $dado_veiculo['id_veiculo']             = $veiculo_extraido->id_veiculo;
                    $dado_veiculo['participacao']           = '';

                    (new OcorrenciaExtraidaVeiculoController)->create($dado_veiculo);
                }

                foreach ($value->objetos as $objeto){
                    $tipo_objeto['objeto'] = $objeto->tipo;

                    $dado_objeto['id_tipo_objeto'] = (new TipoObjetoController)->create($tipo_objeto);

                    $dado_objeto['num_identificacao'] = $objeto->num_serie;
                    $dado_objeto['modelo']            = $objeto->modelo;
                    $dado_objeto['un_medida']         = $objeto->un_med;
                    $dado_objeto['marca']             = $objeto->marca;
                    
                    $objeto_extraido = (new ObjetoDiversoController)->create($dado_objeto);

                    $dado_objeto['id_ocorrencia_extraida'] = $ocorrencia_extraida->id_ocorrencia_extraida;
                    $dado_objeto['id_objeto_diverso']      = $objeto_extraido->id_objeto_diverso;
                    $dado_objeto['quantidade']             = $objeto->quantidade;

                    (new OcorrenciaExtraidaObjetoDiversoController)->create($dado_objeto);
                }
        
                foreach ($value->armas as $arma){
                    $dado_arma['tipo']       = $arma->tipo;
                    $dado_arma['especie']    = $arma->especie;
                    $dado_arma['fabricacao'] = '';
                    $dado_arma['calibre']    = $arma->calibre;
                    $dado_arma['num_serie']  = $arma->num_serie;
                    
                    $arma_extraida = (new ArmaController)->create($dado_arma);

                    $dado_arma['id_ocorrencia_extraida'] = $ocorrencia_extraida->id_ocorrencia_extraida;
                    $dado_arma['id_arma']                = $arma_extraida->id_arma;

                    (new OcorrenciaExtraidaArmaController)->create($dado_arma);
                }

                foreach ($value->drogas as $droga){
                    $dado_droga['tipo'] = $droga->tipo;

                    $droga_extraida = (new DrogaController)->create($dado_droga);

                    $dado_droga['id_ocorrencia_extraida'] = $ocorrencia_extraida->id_ocorrencia_extraida;
                    $dado_droga['id_droga']               = $droga_extraida;
                    $dado_droga['quantidade']             = $droga->quantidade;
                    $dado_droga['un_medida']              = $droga->un_medida;

                    (new OcorrenciaExtraidaDrogaController)->create($dado_droga);
                }
            } else {
                File::delete(public_path() . '\\uploads\\pdf\\' . basename($caminho_servidor));

                $duplicated_pdf .= $value->num_protocol . ", ";
            }
        }

        if ($duplicated_pdf != ""){
            alert('Erro!','As ocorrências possuindo número de protocolo ' . $duplicated_pdf . 
                          ' já foram adicionadas ao sistema', 'warning')->showConfirmButton('Continuar'); 
        }

        if ($fato_inexistente != ""){
            if ($count_fatos_inexistentes > 1) {
                alert('Atenção!','Os fatos ' . $fato_inexistente . 
                          ' não estão cadastrados no sistema, recomenda-se inserí-los no menu de configurações, a fim de novas ocorrências serem adicionadas corretamente', 'warning')->showConfirmButton('Continuar'); 
            } else {
                alert('Atenção!','O fato ' . $fato_inexistente . 
                          ' não está cadastrado no sistema, recomenda-se inserí-lo no menu de configurações, a fim de novas ocorrências serem adicionadas corretamente', 'warning')->showConfirmButton('Continuar'); 
            }
            
        }

        return redirect()->route('show_Importar_Ocorrencia');
    }

    public function create($dados){
        return ocorrencias_extraidas::create([
            'num_protocol'         => $dados['num_protocol'],
            'data_hora'            => $dados['data_hora'],
            'endereco_cep'         => $dados['endereco_cep'],
            'endereco_num'         => $dados['endereco_numero'],
            'endereco_rua'         => $dados['endereco_rua'],
            'descricao_inicial'    => $dados['descricao_inicial'],
            'descricao_ocorrencia' => $dados['descricao'],
            'possui_envolvidos'    => $dados['possui_envolvidos'],
            'possui_veiculos'      => $dados['possui_veiculos'],
            'possui_armas'         => $dados['possui_armas'],
            'possui_drogas'        => $dados['possui_drogas'],
            'possui_objetos'       => $dados['possui_objetos'],
            'possui_animais'       => $dados['possui_animais'],  
            'pdf_caminho_servidor' => $dados['pdf_caminho_servidor'], 
            'revisado'             => $dados['revisado'],
            'id_bairro'            => $dados['id_bairro'],
            'id_usuario'           => Auth::id()
        ]);
    }

    public function update($dados){
        $ocorrencia_extraida = ocorrencias_extraidas::find($dados['id_ocorrencia_extraida']);

        $ocorrencia_extraida->update(['num_protocol'         => $dados['num_protocol'],
                                      'data_hora'            => $dados['data_hora'],
                                      'endereco_cep'         => $dados['endereco_cep'],
                                      'endereco_rua'         => $dados['endereco_rua'],
                                      'endereco_num'         => $dados['endereco_numero'],
                                      'descricao_inicial'    => $dados['descricao_inicial'],
                                      'descricao_ocorrencia' => $dados['descricao'],
                                      'revisado'             => $dados['revisado'],
                                      'id_bairro'            => $dados['id_bairro']
        ]);

        return $ocorrencia_extraida;
    }

    public function create_ocorrencia($dados){
        return ocorrencias::create([
            'num_protocol'           => $dados['num_protocol'],
            'data_hora'              => $dados['data_hora'],
            'endereco_cep'           => $dados['endereco_cep'],
            'endereco_num'           => $dados['endereco_num'],
            'endereco_rua'           => $dados['endereco_rua'],
            'descricao_inicial'      => $dados['descricao_inicial'],
            'descricao_ocorrencia'   => $dados['descricao_ocorrencia'],
            'id_bairro'              => $dados['id_bairro'],
            'id_ocorrencia_extraida' => $dados['id_ocorrencia_extraida'],
            'id_usuario'            => Auth::id()
        ]);
    }
}