<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function show_Dashboard(){
        $total_drugs_current_month = 0;
        $total_drugs_last_month    = 0;

        $query_drogas = DB::table('ocorrencias_drogas')
                          ->select('ocorrencias_drogas.quantidade', 'ocorrencias_drogas.un_medida')
                          ->join("ocorrencias", "ocorrencias_drogas.id_ocorrencia", "ocorrencias.id_ocorrencia")
                          ->whereBetween('ocorrencias.data_hora', [date("Y-m-01"), date("Y-m-01", strtotime("+1 months"))])
                          ->get();
        
        foreach ($query_drogas as $query_droga){
            if ($query_droga->un_medida == "Kg") {
                $total_drugs_current_month += $query_droga->quantidade;
            }
            if ($query_droga->un_medida == "g") {
                $total_drugs_current_month += $query_droga->quantidade * 0.001;
            }
        }

        $query_drogas = DB::table('ocorrencias_drogas')
                          ->select('ocorrencias_drogas.quantidade', 'ocorrencias_drogas.un_medida', 'ocorrencias.data_hora')
                          ->join("ocorrencias", "ocorrencias_drogas.id_ocorrencia", "ocorrencias.id_ocorrencia")
                          ->whereBetween('ocorrencias.data_hora', [date("Y-m-01", strtotime("-1 months")), date("Y-m-01")])
                          ->get();

        foreach ($query_drogas as $query_droga){
            if ($query_droga->un_medida == "Kg") {
                $total_drugs_last_month += $query_droga->quantidade;
            }
            if ($query_droga->un_medida == "g") {
                $total_drugs_last_month += $query_droga->quantidade * 0.001;
            }
        }
        
        $drugs_balance = (100 * ($total_drugs_current_month - $total_drugs_last_month))/$total_drugs_last_month;

        $total_drugs_current_month = number_format($total_drugs_current_month, 1, ',', '');
        $drugs_balance             = number_format($drugs_balance, 1, ',', '') . " %";

        return view('dashboard', compact('total_drugs_current_month', 'drugs_balance'));
    }
}
