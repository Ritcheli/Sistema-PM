<?php

namespace App\Http\Controllers;

use App\Models\ocorrencias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OcorrenciaController extends Controller
{
    public function show_Cad_Ocorrencia(){
        $Who_Call = "Cad_Ocorrencia";

        return view('ocorrencia.ocorrencia', compact('Who_Call'));
    }

    public function show_Visualizar_Ocorrencia($id_ocorrencia){
        $ocorrencia = DB::table('ocorrencias')
                        ->select('num_protocol', DB::raw('DATE_FORMAT(ocorrencias.data_hora, "%d/%m/%Y") as data'), DB::raw('DATE_FORMAT(ocorrencias.data_hora, "%H:%i:%s") as hora'), 'endereco_cep', 'endereco_num', 'endereco_rua', 
                                 'descricao_inicial', 'descricao_ocorrencia', 'id_bairro')
                        ->where('ocorrencias.id_ocorrencia', $id_ocorrencia)
                        ->get();

        $fatos = DB::table('ocorrencias_fatos_ocorrencias')
                   ->select(DB::raw('GROUP_CONCAT(fatos_ocorrencias.natureza SEPARATOR " - ") as natureza'))
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

        $endereco = $this->get_Endereco($ocorrencia[0]->id_bairro);

        return view('ocorrencia.visualizar_ocorrencia', compact('ocorrencia', 'pessoas', 'endereco', 'fatos'));
    }

    public function show_Editar_Ocorrencia($id_ocorrencia){
        $Who_Call = "Editar_Ocorrencia";

        $ocorrencia = DB::table('ocorrencias')
                        ->where('id_ocorrencia', $id_ocorrencia)
                        ->get();
        
        $pessoas = DB::table('pessoas')
                     ->select('pessoas.id_pessoa', 'pessoas.nome', 'pessoas.RG_CPF')
                     ->leftJoin('ocorrencias_pessoas', 'pessoas.id_pessoa', 'ocorrencias_pessoas.id_pessoa')
                     ->where('ocorrencias_pessoas.id_ocorrencia', $id_ocorrencia)
                     ->get();    
        
        $endereco = $this->get_Endereco($ocorrencia[0]->id_bairro);

        return view('ocorrencia.ocorrencia', compact('Who_Call', 'ocorrencia', 'pessoas', 'endereco'));
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
                         ->where('pessoas.nome', $pessoa);
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
            'num_protocol'    => ['required'],
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

        if (array_key_exists('envolvidos', $dados_ocor)){
            for ($i = 0; $i < count($dados_ocor['envolvidos']); $i++){
                $dados_env['id_pessoa']     =  $dados_ocor['envolvidos'][$i];
                $dados_env['id_ocorrencia'] =  $ocorrencia->id_ocorrencia;
                 
                (new OcorrenciaPessoaController)->create($dados_env);
             }
        }

        alert('Sucesso','Ocorrência cadastrada', 'success')->showConfirmButton('Continuar');
        
        return route('show_Dashboard');
    }

    public function editar_Ocorrencia(Request $request){
        $validator = Validator::make($request->all(), [
            'num_protocol'    => ['required'],
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
        
        $dados_ocor = $request->only('id_ocorrencia', 'num_protocol', 'data_hora', 'endereco_cep', 'endereco_numero', 'endereco_rua', 'descricao', 'envolvidos');

        // Configuração do cadastro do endereço
        $dados_bairro = $request->only('endereco_bairro');
        $dados_cidade = $request->only('endereco_cidade');
        $dados_estado = $request->only('endereco_estado');

        $dados_ocor['id_bairro'] = $this->salvar_Endereco($dados_estado, $dados_cidade, $dados_bairro);

        $this->update($dados_ocor);

        DB::table('ocorrencias_pessoas')
          ->where('ocorrencias_pessoas.id_ocorrencia', $dados_ocor['id_ocorrencia'])
          ->delete();
        
        if (array_key_exists('envolvidos', $dados_ocor)){
            for ($i = 0; $i < count($dados_ocor['envolvidos']); $i++){
                $dados_env['id_pessoa']     =  $dados_ocor['envolvidos'][$i];
                $dados_env['id_ocorrencia'] =  $dados_ocor['id_ocorrencia'];
                 
                (new OcorrenciaPessoaController)->create($dados_env);
            }
        } 

        alert('Sucesso','Ocorrência atualizada', 'success')->showConfirmButton('Continuar');
        return route('show_Busca_Ocorrencia');
    }

    public function excluir_Ocorrencia(Request $request){
        DB::table('ocorrencias_pessoas')
          ->where('ocorrencias_pessoas.id_ocorrencia', $request->id_ocorrencia)
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
}
