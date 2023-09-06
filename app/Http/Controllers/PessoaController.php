<?php

namespace App\Http\Controllers;

use App\Models\pessoas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Image;

class PessoaController extends Controller
{
    public function show_Cad_Pessoa(){
        $Who_Call = "Cad_Pessoa";

        return view('pessoa.pessoa', compact("Who_Call"));
    }

    public function show_Busca_Pessoa(Request $request){
        $nome    = $request->input_nome;
        $alcunha = $request->input_alcunha; 

        $query = DB::table('pessoas')
                     ->select('id_pessoa', 'nome', 'alcunha', 'RG_CPF', DB::raw('DATE_FORMAT(pessoas.data_nascimento, "%d/%m/%Y") as data_nascimento'));


        if ($request->input_nome != null){
            $query->where('pessoas.nome', 'like', '%' . $nome . '%');
        }

        if ($request->input_alcunha != null){
            $query->where('pessoas.alcunha', 'like', '%' . $alcunha . '%');
        }

        $pessoas = $query->paginate(10);

        return view('pessoa.busca_pessoa', compact('pessoas', 'nome', 'alcunha'));
    }

    public function show_Visualizar_Pessoa($id_pessoa){
        $fotos_pessoas = DB::table('fotos_pessoas')
                           ->select('id_foto_pessoa', 'caminho_servidor')
                           ->where('id_pessoa', $id_pessoa)
                           ->get();

        $first = DB::table('fotos_pessoas')
                   ->select( DB::raw('MIN(id_foto_pessoa) as first'))
                   ->where('id_pessoa', $id_pessoa)
                   ->get();

        $pessoa = DB::table('pessoas')
                     ->select('id_pessoa', 'nome', 'alcunha', DB::raw('DATE_FORMAT(pessoas.data_nascimento, "%d/%m/%Y") as data_nascimento'), 'RG_CPF', 'telefone', 'observacao')
                     ->where('id_pessoa', $id_pessoa)
                     ->get();
        
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
        
        return view('pessoa.visualizar_pessoa', compact('fotos_pessoas', 'first', 'pessoa', 'ocorrencias'));
    }

    public function nova_Pessoa(Request $request){
        if ($request->Who_Call == "Modal_Pessoa"){
            $validator = Validator::make($request->all(), [
                'nome'              => ['required', 'string', 'max:60'],
                'telefone'          => ['max:15'],
                'CPF_RG'            => ['max:11'],
                'alcunha'           => ['max:60'],
                'observacao_pessoa' => ['max:65535'],
                'files.*'           => ['mimes:jpg,jpeg,png'],
            ]);

            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
        }

        if ($request->Who_Call == "Pessoa"){
            $request->validate([
                'nome'              => ['required', 'string', 'max:60'],
                'telefone'          => ['max:15'],
                'CPF_RG'            => ['max:11'],
                'alcunha'           => ['max:60'],
                'observacao_pessoa' => ['max:65535'],
                'files.*'          => ['mimes:jpg,jpeg,png']
            ]);
        }

        $data = $request->only('nome', 'telefone', 'CPF_RG', 'data_nascimento', 'alcunha', 'observacao_pessoa');

        $data['id_estado'] = 1;

        $pessoa = $this->create($data);

        if ($request->hasFile('files')){
            foreach ($request->file('files') as $file) {
                $this->save_img($file, $pessoa->id_pessoa);
            }           
        }

        if ($request->Who_Call == "Modal_Pessoa"){
            return response()->json([
                'pessoa' => $pessoa,
            ]);
        }

        if ($request->Who_Call == "Pessoa"){ 
            alert('Sucesso','Pessoa cadastrada!', 'success')->showConfirmButton('Continuar');

            return redirect(route('show_Dashboard'));
        }
    }

    public function show_Editar_Pessoa($id_pessoa){
        $Who_Call = "Editar_Pessoa";

        $pessoa = DB::table('pessoas')
                    ->where('id_pessoa', $id_pessoa)
                    ->get();

        return view('pessoa.pessoa', compact("pessoa" ,"Who_Call"));
    }

    public function buscar_Pessoa_Ocorr_Modal(Request $request){
        $total_rows = DB::table('pessoas')
                    ->select('id_pessoa')
                    ->where('nome', 'like', '%' . $request->nome . '%')
                    ->count();

        $pessoas = DB::table('pessoas')
                     ->select('id_pessoa', 'nome', 'RG_CPF')
                     ->where('nome', 'like', '%' . $request->nome . '%')
                     ->skip($request->items_per_page * $request->current_page)
                     ->take($request->items_per_page)   
                     ->get();

        return response()->json([
            'pessoas'    => $pessoas,
            'total_rows' => $total_rows
        ]);
    }

    public function editar_Pessoa(Request $request){
        if ($request->Who_Call == "Modal_Pessoa"){
            $validator = Validator::make($request->all(), [
                'nome'              => ['required', 'string', 'max:60'],
                'telefone'          => ['max:15'],
                'CPF_RG'            => ['max:11'],
                'alcunha'           => ['max:60'],
                'observacao_pessoa' => ['max:65535'],
                'files.*'           => ['mimes:jpg,jpeg,png'],
            ]);

            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
        }

        if ($request->Who_Call == "Pessoa"){
            $request->validate([
                'nome'              => ['required', 'string', 'max:60'],
                'telefone'          => ['max:15'],
                'CPF_RG'            => ['max:11'],
                'alcunha'           => ['max:60'],
                'observacao_pessoa' => ['max:65535'],
                'files.*'           => ['mimes:jpg,jpeg,png']
            ]);
        }

        $dados = $request->only('id_pessoa', 'nome', 'telefone', 'CPF_RG', 'data_nascimento', 'alcunha', 'observacao_pessoa');

        $pessoa = $this->update($dados);

        $fotos_pessoas = (new FotoPessoaController)->buscar_Foto_Pessoa($pessoa->id_pessoa);
        
        if ($request->hasFile('files')) {

            foreach ($request->file('files') as $file){
                $caminho_servidor = URL::to('/') . '/uploads/fotos_pessoas/' . $file->getClientOriginalName();

                // Adiciona imagens novas relacionadas a pessoa
                if ($fotos_pessoas->where('caminho_servidor', $caminho_servidor)->isEmpty()) {
                    $this->save_img($file, $pessoa->id_pessoa);
                }     
            }

            foreach ($fotos_pessoas as $foto_pessoa){
                $found = false;
                
                foreach ($request->file('files') as $file){
                    $caminho_servidor = URL::to('/') . '/uploads/fotos_pessoas/' . $file->getClientOriginalName();
    
                    if ($foto_pessoa->caminho_servidor == $caminho_servidor) {
                        $found = true;

                        break;
                    }
                }
                
                if ($found == false) {
                    // Processo de remoção de imagem
                    $this->delete_img($foto_pessoa);

                }
            }
        } 

        // Caso nenhuma imagem seja retornada mas ainda sim haja imagens relacionadas a pessoa, remove todas elas
        else if ($fotos_pessoas->isNotEmpty()){
            foreach ($fotos_pessoas as $foto_pessoa) {
                $this->delete_img($foto_pessoa);
            }
        }
        
        if ($request->Who_Call == "Modal_Pessoa"){
            return response()->json([
                'pessoa' => $pessoa,
            ]);
        }

        if ($request->Who_Call == "Pessoa"){ 
            alert('Sucesso','Pessoa atualizada!', 'success')->showConfirmButton('Continuar');

            return redirect()->route('show_Busca_Pessoa');
        }
    }

    public function excluir_Pessoa(Request $request){
        if (DB::table('ocorrencias_pessoas')->where('id_pessoa', $request->id_pessoa)->doesntExist()) {
            $fotos_pessoas = DB::table('fotos_pessoas')
                               ->select('id_foto_pessoa', 'caminho_servidor')
                               ->where('id_pessoa', $request->id_pessoa)
                               ->get();

            if ($fotos_pessoas->isNotEmpty()){
                foreach ($fotos_pessoas as $foto_pessoa) {
                    $this->delete_img($foto_pessoa);
                }
            }
            
            DB::table('pessoas')
              ->where('id_pessoa', $request->id_pessoa)
              ->delete();

            alert('Sucesso','Pessoa foi excluída com sucesso', 'success')->showConfirmButton('Continuar');
        } else {
            alert('Erro!','Não é possível excluir uma pessoa relacionada a uma ocorrência', 'warning')->showConfirmButton('Continuar');
        }        
    }

    public function show_Editar_Pessoa_Ocorr_Modal(Request $request){
        $pessoas = DB::table('pessoas')
                     ->select('nome', 'data_nascimento', 'telefone', 'RG_CPF', 'alcunha', 'observacao')
                     ->where('id_pessoa', $request->id_pessoa)
                     ->get();

        $fotos_pessoas = (new FotoPessoaController)->buscar_Foto_Pessoa($request->id_pessoa);

        return response()->json([
            'pessoas'       => $pessoas,
            'fotos_pessoas' => $fotos_pessoas
        ]);
    }

    public function save_img($file, $id_pessoa){
        $name             = time().'_'.$file->getClientOriginalName();
        $caminho_img      = public_path('uploads\fotos_pessoas') . '/' . $name;
        $caminho_servidor = URL::to('/') . '/uploads/fotos_pessoas/' . $name;

        // Redimensionando a imagem
        $new_img = Image::fromFile($file->path());
        $new_img->resize(250, 250);
        $new_img->save($caminho_img);

        $dado_foto = [
            'caminho_servidor' => $caminho_servidor,
            'id_pessoa'        => $id_pessoa
        ];

        (new FotoPessoaController)->create($dado_foto);
    }

    public function delete_img($foto_pessoa){
        File::delete(public_path() . '\\uploads\\fotos_pessoas\\' . basename($foto_pessoa->caminho_servidor));

        (new FotoPessoaController)->destroy($foto_pessoa->id_foto_pessoa);
    }

    public function update($data){
        $pessoa = pessoas::find($data['id_pessoa']);

        $pessoa->update(['nome'            => $data['nome'],
                         'data_nascimento' => $data['data_nascimento'],
                         'telefone'        => $data['telefone'],
                         'RG_CPF'          => $data['CPF_RG'],
                         'alcunha'         => $data['alcunha'],
                         'observacao'      => $data['observacao_pessoa']]);

        return $pessoa;
    }

    public function create($data){
        return pessoas::create([
            'nome'            => $data['nome'],
            'data_nascimento' => $data['data_nascimento'],
            'telefone'        => $data['telefone'],
            'RG_CPF'          => $data['CPF_RG'],
            'alcunha'         => $data['alcunha'],
            'observacao'      => $data['observacao_pessoa'], 
            'id_estado'       => $data['id_estado'],
            'id_usuario'      => Auth::id()
        ]);
    }
}
