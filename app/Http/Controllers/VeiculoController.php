<?php

namespace App\Http\Controllers;

use App\Models\veiculos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VeiculoController extends Controller
{
    public function novo_Veiculo(Request $request){
        $validator = Validator::make($request->all(), [
            'placa'                => ['required', 'string', 'max:10', 'unique:veiculos'],
            'cor_veiculo'          => ['required', 'string', 'max:30'], 
            'chassi'               => ['required', 'max:30', 'unique:veiculos'],
            'renavam'              => ['required', 'max:15', 'unique:veiculos'],
            'marca_modelo_veiculo' => ['required', 'max:45'],
            'participacao_veiculo' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }

        $data = $request->only('placa', 'cor_veiculo', 'chassi', 'renavam', 'marca_modelo_veiculo');

        $veiculo = $this->create($data);

        return response()->json([
            'veiculo' => $veiculo
        ]);
    }  
    
    public function buscar_Veiculo_Modal(Request $request){
        $total_rows = DB::table('veiculos')
                        ->select('id_veiculo')
                        ->where('placa', 'like', '%' . $request->placa . '%')
                        ->count();

        $veiculos = DB::table('veiculos')
                    ->select('placa', 'cor', 'renavam', 'marcas_veiculos.marca')
                    ->leftJoin('marcas_veiculos', 'veiculos.id_marca_veiculo', 'marcas_veiculos.id_marca_veiculo')
                    ->where('placa', 'like', '%' . $request->placa . '%')
                    ->skip($request->items_per_page * $request->current_page)
                    ->take($request->items_per_page)   
                    ->get();

        return response()->json([
            'veiculos'    => $veiculos,
            'total_rows' => $total_rows
        ]);
    }

    public function buscar_Veiculo_Por_Placa(Request $request){
        $veiculo = DB::table('veiculos')
                     ->select('id_veiculo', 'placa', 'cor', 'renavam', 'chassi', 'marcas_veiculos.marca')
                     ->leftJoin('marcas_veiculos', 'veiculos.id_marca_veiculo', 'marcas_veiculos.id_marca_veiculo')
                     ->where('placa', $request->placa)
                     ->first();

        return response()->json([
            'veiculo' => $veiculo
        ]);
    }

    public function create($data){
        $marca_veiculo = DB::table('marcas_veiculos')->where('marca', $data['marca_modelo_veiculo'])->first();
        
        if ($marca_veiculo == null){
            $marca_veiculo = (new MarcaVeiculoController)->create($data['marca_modelo_veiculo']);
        }

        return veiculos::create([
            'placa'            => $data['placa'],
            'cor'              => $data['cor_veiculo'],
            'chassi'           => $data['chassi'],
            'renavam'          => $data['renavam'],
            'id_marca_veiculo' => $marca_veiculo->id_marca_veiculo
        ]);
    }
}
