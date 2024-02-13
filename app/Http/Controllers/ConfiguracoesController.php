<?php

namespace App\Http\Controllers;

use App\Imports\FatosImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ConfiguracoesController extends Controller
{
    public function show_Configuracoes(){
        $grupos = DB::table('grupos_fatos')
                    ->select('*')
                    ->get();

        return view('configuracoes.configuracoes', compact('grupos'));
    }

    public function importar_Fatos(Request $request){
        $request->validate([
            'file' => ['mimes:csv,xlsx,xls']
        ]);

        if ($request->hasFile('file')){
            $collection = Excel::toCollection(new FatosImport, $request->file('file'));

            for ($i = 2; $i < count($collection[0]); $i++){
                if ($collection[0][$i][0] != 'GRUPO'){
                    $grupo_fato = DB::table('grupos_fatos')
                                    ->where('grupos_fatos.nome', $collection[0][$i][0])
                                    ->first();
                    
                    if ($grupo_fato == null){
                        $dado_grupo_fato['nome'] = $collection[0][$i][0];

                        $grupo_fato = (new GrupoFatoController)->create($dado_grupo_fato);
                    }
                }

                if ($collection[0][$i][1] != 'NATUREZA'){
                    $fatos_ocorrencias = DB::table('fatos_ocorrencias')
                                        ->where('fatos_ocorrencias.natureza', preg_replace('/\s+/', ' ', $collection[0][$i][1]))
                                        ->first();
                                        
                    
                    if ($fatos_ocorrencias == null){
                        $dado_fato_ocorrencia['natureza']           = preg_replace('/\s+/', ' ', $collection[0][$i][1]);
                        $dado_fato_ocorrencia['potencial_ofensivo'] = $collection[0][$i][2];
                        $dado_fato_ocorrencia['id_grupo_fato']      = $grupo_fato->id_grupo_fato;

                        (new FatoOcorrenciaController)->create($dado_fato_ocorrencia);
                    }
                }
            }
            alert('Sucesso','Fatos importados com sucesso', 'success')->showConfirmButton('Continuar');

        } else {
            alert('Erro!', 'Selecione um arquivo de fatos para importar', 'error')->showConfirmButton('Continuar'); 
        }

        return redirect()->route('show_Configuracoes');
    }

    public function adiciona_Fatos_Manual(Request $request){
        $validator = Validator::make($request->all(), [
            'fato'               => ['required'],
            'grupo'              => ['required'],
            'potencial_ofensivo' => ['required']
        ]);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }

        $dados = $request->only('fato', 'grupo', 'potencial_ofensivo');
        
        $dados_grupo['nome']              = $dados['grupo'];
        $dados_fato['natureza']           = $dados['fato'];
        $dados_fato['potencial_ofensivo'] = $dados['potencial_ofensivo'];  

        if (is_numeric($dados_grupo['nome']) == false) {
            $grupo = (new GrupoFatoController)->create($dados_grupo);

            $dados_grupo['nome'] = $grupo->id_grupo_fato;
        }

        $dados_fato['id_grupo_fato'] = $dados_grupo['nome'];

        (new FatoOcorrenciaController)->create($dados_fato);
    }
}
