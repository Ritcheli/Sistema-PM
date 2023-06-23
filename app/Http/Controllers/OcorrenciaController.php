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
        return view('ocorrencia.cad_ocorrencia');
    }

    public function show_Visualizar_Ocorrencia($id_ocorrencia){
        // $ocorrencia = DB::table('ocorrencias')
        //                 ->select('num_protocol', 'data_hora', 'endereco_cep', 'endereco_num')

        return view('ocorrencia.visualizar_ocorrencia');
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
                   ->select('ocorrencias.id_ocorrencia', 'ocorrencias.num_protocol', 'ocorrencias.descricao_ocorrencia', 'ocorrencias.data_hora', DB::raw('GROUP_CONCAT(pessoas.nome SEPARATOR " - ") AS pessoas_envolvidas'))
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

        $id_estado = (new EstadoController)->create($dados_estado);
        $dados_cidade['id_estado'] = $id_estado;

        $id_cidade = (new CidadeController)->create($dados_cidade);
        $dados_bairro['id_cidade'] = $id_cidade;

        $id_bairro = (new BairroController)->create($dados_bairro);
        $dados_ocor['id_bairro'] = $id_bairro;

        $ocorrencia = $this->create($dados_ocor);

        if (array_key_exists('envolvidos', $dados_ocor)){
            for ($i = 0; $i < count($dados_ocor['envolvidos']); $i++){
                $dados_env['id_pessoa']     =  $dados_ocor['envolvidos'][$i];
                $dados_env['id_ocorrencia'] =  $ocorrencia->id_ocorrencia;
                 
                (new OcorrenciaPessoaController)->create($dados_env);
             }
        }

        return route('show_Dashboard');
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
}
