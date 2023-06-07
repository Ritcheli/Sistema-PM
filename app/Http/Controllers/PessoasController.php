<?php

namespace App\Http\Controllers;

use App\Models\pessoas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Image;

use function PHPUnit\Framework\isEmpty;

class PessoasController extends Controller
{
    public function nova_Pessoa_Ocorr(Request $request){
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

        $data = $request->only('nome', 'telefone', 'CPF_RG', 'data_nascimento', 'alcunha', 'observacao_pessoa');

        $pessoa = $this->create($data);

        if ($request->hasFile('files')){
            foreach ($request->file('files') as $file) {
                $this->save_img($file, $pessoa->id_pessoa);
            }           
        }
        return response()->json([
            'pessoa' => $pessoa,
        ]);
    }

    public function buscar_Pessoa_Ocorr_Modal(Request $request){
        $pessoas = DB::table('pessoas')
                     ->select('id_pessoa', 'nome', 'RG_CPF')
                     ->where('nome', 'like', '%' . $request->nome . '%')->get();

        return response()->json([
            'pessoas' => $pessoas,
        ]);
    }

    public function salvar_Edit_Pessoa_Ocorr_Modal(Request $request){
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

        $dados = $request->only('id_pessoa', 'nome', 'telefone', 'CPF_RG', 'data_nascimento', 'alcunha', 'observacao_pessoa');

        $pessoa = $this->update($dados);

        $fotos_pessoas = (new FotosPessoasController)->buscar_Foto_Pessoa($pessoa->id_pessoa);
        
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
        
        return response()->json([
            'pessoa' => $pessoa
        ]);
    }

    public function editar_Pessoa_Ocorr_Modal(Request $request){
        $pessoas = DB::table('pessoas')
                     ->select('nome', 'data_nascimento', 'telefone', 'RG_CPF', 'alcunha', 'observacao')
                     ->where('id_pessoa', $request->id_pessoa)
                     ->get();

        $fotos_pessoas = (new FotosPessoasController)->buscar_Foto_Pessoa($request->id_pessoa);

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

        (new FotosPessoasController)->create($dado_foto);
    }

    public function delete_img($foto_pessoa){
        File::delete(public_path() . '\\uploads\\fotos_pessoas\\' . basename($foto_pessoa->caminho_servidor));

        (new FotosPessoasController)->destroy($foto_pessoa->id_foto_pessoa);
    }

    public function update(array $data){
        $pessoa = pessoas::find($data['id_pessoa']);

        $pessoa->update(['nome'            => $data['nome'],
                         'data_nascimento' => $data['data_nascimento'],
                         'telefone'        => $data['telefone'],
                         'RG_CPF'          => $data['CPF_RG'],
                         'alcunha'         => $data['alcunha'],
                         'observacao'      => $data['observacao_pessoa']]);

        return $pessoa;
    }

    public function create(array $data){
        return pessoas::create([
            'nome'            => $data['nome'],
            'data_nascimento' => $data['data_nascimento'],
            'telefone'        => $data['telefone'],
            'RG_CPF'          => $data['CPF_RG'],
            'alcunha'         => $data['alcunha'],
            'observacao'      => $data['observacao_pessoa'],    
            'id_usuario'      => Auth::id()
        ]);
    }
}
