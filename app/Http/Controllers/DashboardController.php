<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function show_Dashboard(){
        $total_drugs_current_month   = 0;
        $total_drugs_last_month      = 0;
        $total_pessoas_current_month = 0;
        $total_pessoas_last_month    = 0;
        $total_armas_current_month   = 0;
        $total_armas_last_month      = 0;

        // Buscar pelas estatísticas referentes às drogas
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
        
        // Descrição array
        // 0 = Aumento em %
        // 1 = Descrição de aumento ou diminuição
        // 2 = Valor total do mês
        if ($total_drugs_last_month > 0){
            $drugs_balance[0] = (100 * ($total_drugs_current_month - $total_drugs_last_month))/$total_drugs_last_month;
        } else $drugs_balance[0] = 0;

        if ($drugs_balance[0] > 0) {
            $drugs_balance[1] = "Aumento";
        } else {
            $drugs_balance[0] = $drugs_balance[0] * (-1);
            $drugs_balance[1] = "Diminuição";
        }

        $drugs_balance[2] = number_format($total_drugs_current_month, 1, ',', '');
        $drugs_balance[0] = number_format($drugs_balance[0], 1, ',', '') . " %";

        // Buscar pelas estatísticas referentes às pessoas apreendidas
        $query_pessoas = DB::table('ocorrencias')
                           ->select('ocorrencias.id_ocorrencia', 'pessoas.id_pessoa', DB::raw('COUNT(*) as count_pessoa'))
                           ->join('ocorrencias_pessoas', 'ocorrencias.id_ocorrencia', 'ocorrencias_pessoas.id_ocorrencia')
                           ->join('pessoas', 'ocorrencias_pessoas.id_pessoa', 'pessoas.id_pessoa')
                           ->join('ocorrencias_fatos_ocorrencias', 'ocorrencias.id_ocorrencia', 'ocorrencias_fatos_ocorrencias.id_ocorrencia')
                           ->join('fatos_ocorrencias', 'ocorrencias_fatos_ocorrencias.id_fato_ocorrencia', 'fatos_ocorrencias.id_fato_ocorrencia')
                           ->whereIn('fatos_ocorrencias.natureza', ["Arrebatamento de preso", "Cumprimento de Mandado de Prisão/Apreensão de Adolescente", "Recaptura de foragido/evadido",
                                                                    "Prisão civil por falta de pagamento de prestação alimentícia"])
                           ->whereBetween('ocorrencias.data_hora', [date("Y-m-01"), date("Y-m-01", strtotime("+1 months"))])
                           ->first();
        
        $total_pessoas_current_month = $query_pessoas->count_pessoa;

        $query_pessoas = DB::table('ocorrencias')
                           ->select('ocorrencias.id_ocorrencia', 'pessoas.id_pessoa', DB::raw('COUNT(*) as count_pessoa'))
                           ->join('ocorrencias_pessoas', 'ocorrencias.id_ocorrencia', 'ocorrencias_pessoas.id_ocorrencia')
                           ->join('pessoas', 'ocorrencias_pessoas.id_pessoa', 'pessoas.id_pessoa')
                           ->join('ocorrencias_fatos_ocorrencias', 'ocorrencias.id_ocorrencia', 'ocorrencias_fatos_ocorrencias.id_ocorrencia')
                           ->join('fatos_ocorrencias', 'ocorrencias_fatos_ocorrencias.id_fato_ocorrencia', 'fatos_ocorrencias.id_fato_ocorrencia')
                           ->whereIn('fatos_ocorrencias.natureza', ["Arrebatamento de preso", "Cumprimento de Mandado de Prisão/Apreensão de Adolescente", "Recaptura de foragido/evadido",
                                                                    "Prisão civil por falta de pagamento de prestação alimentícia"])
                           ->whereBetween('ocorrencias.data_hora', [date("Y-m-01", strtotime("-1 months")), date("Y-m-01")])
                           ->first();

        $total_pessoas_last_month = $query_pessoas->count_pessoa;
        
        // Descrição array
        // 0 = Aumento em %
        // 1 = Descrição de aumento ou diminuição
        // 2 = Valor total do mês
        if ($total_pessoas_last_month > 0){
            $pessoas_balance[0] =  (100 * ($total_pessoas_current_month - $total_pessoas_last_month))/$total_pessoas_last_month;
        } else $pessoas_balance[0] = 0;

        if ($pessoas_balance[0] > 0) {
            $pessoas_balance[1] = "Aumento";
        } else {
            $pessoas_balance[0] = $pessoas_balance[0] * (-1);
            $pessoas_balance[1] = "Diminuição";
        }

        $pessoas_balance[0] = number_format($pessoas_balance[0], 1, ',', '') . " %";
        $pessoas_balance[2] = $total_pessoas_current_month;

        // Buscar pelas estatísticas referentes às pessoas apreendidas
        $query_armas = DB::table("ocorrencias")
                         ->select("ocorrencias.id_ocorrencia", "ocorrencias.data_hora", "ocorrencias_armas.id_arma", DB::raw("COUNT(*) as count_arma"))
                         ->join("ocorrencias_armas", "ocorrencias.id_ocorrencia", "ocorrencias_armas.id_ocorrencia")
                         ->whereBetween('ocorrencias.data_hora', [date("Y-m-01"), date("Y-m-01", strtotime("+1 months"))])
                         ->first();
        
        $total_armas_current_month = $query_armas->count_arma;

        $query_armas = DB::table("ocorrencias")
                         ->select("ocorrencias.id_ocorrencia", "ocorrencias.data_hora", "ocorrencias_armas.id_arma", DB::raw("COUNT(*) as count_arma"))
                         ->join("ocorrencias_armas", "ocorrencias.id_ocorrencia", "ocorrencias_armas.id_ocorrencia")
                         ->whereBetween('ocorrencias.data_hora', [date("Y-m-01", strtotime("-1 months")), date("Y-m-01")])
                         ->first();
        
        $total_armas_last_month = $query_armas->count_arma;
                         
        // Descrição array
        // 0 = Aumento em %
        // 1 = Descrição de aumento ou diminuição
        // 2 = Valor total do mês
        
        if ($total_armas_last_month > 0){
            $armas_balance[0] =  (100 * ($total_armas_current_month - $total_armas_last_month))/$total_armas_last_month;
        } else $armas_balance[0] = 0;

        if ($armas_balance[0] > 0) {
            $armas_balance[1] = "Aumento";
        } else {
            $armas_balance[0] = $armas_balance[0] * (-1);
            $armas_balance[1] = "Diminuição";
        }

        $armas_balance[0] = number_format($armas_balance[0], 1, ',', '') . " %";
        $armas_balance[2] = $total_armas_current_month;


        return view('dashboard', compact('drugs_balance', 'pessoas_balance', 'armas_balance'));
    }

    public function get_Ocorr_Chart_Data(){
        $number_of_months = 5;
        $j = 0;

        $query_ocorrencias = DB::table("ocorrencias")
                               ->select(DB::raw("concat(Year(ocorrencias.data_hora), '-', LPAD(Month(ocorrencias.data_hora), '2', '0'), '-01') as Date_filter"), DB::raw("Count(*) as Count_mes"))
                               ->where('ocorrencias.data_hora', ">=", date("Y-m-01", strtotime("-" . strval($number_of_months) . " months")))
                               ->groupBy(DB::raw("Month(ocorrencias.data_hora)"))
                               ->orderBy(DB::raw("date(Date_filter)"))
                               ->get();

        for ($i = 0; $i <= 5; $i++){
            if (date('n', strtotime($query_ocorrencias[$j]->Date_filter)) == (date('n', strtotime(date("Y-m-01", strtotime("-" . strval($number_of_months - $i) . " months")))))) {
                $month = $this->get_Month_Portuguese(date('n', strtotime($query_ocorrencias[$j]->Date_filter)));
                $qtd   = $query_ocorrencias[$j]->Count_mes;

                $data_result[$month] = $qtd;

                $j++;
            } else {
                $month = $this->get_Month_Portuguese(date('n', strtotime(date("Y-m-01", strtotime("-" . strval($number_of_months - $i) . " months")))));

                $data_result[$month] = 0;
            }
        }

        return $data_result;
    }

    public function get_Grupo_Chart_Data(){
        $number_of_months = 1;

        $query_Grupos = DB::table('ocorrencias')
                         ->select('grupos_fatos.nome', DB::raw('COUNT(*) as count_grupo'))
                         ->join('ocorrencias_fatos_ocorrencias', 'ocorrencias.id_ocorrencia', 'ocorrencias_fatos_ocorrencias.id_ocorrencia')
                         ->join('fatos_ocorrencias', 'ocorrencias_fatos_ocorrencias.id_fato_ocorrencia', 'fatos_ocorrencias.id_fato_ocorrencia')
                         ->join('grupos_fatos', 'fatos_ocorrencias.id_grupo_fato', 'grupos_fatos.id_grupo_fato')
                         ->where('ocorrencias.data_hora', '>=', date("Y-m-01", strtotime("-" . strval($number_of_months) . " months")))
                         ->groupBy('grupos_fatos.nome')
                         ->orderByDesc('count_grupo')
                         ->limit(5)
                         ->get();
        
        foreach ($query_Grupos as $query_Grupo){
            $data_result[$query_Grupo->nome] = $query_Grupo->count_grupo;
        }

        return $data_result;
    }

    public function get_Month_Portuguese ($month_number){
        $month = array(
            '',
            'Janeiro',
            'Fevereiro',
            'Março',
            'Abril',
            'Maio',
            'Junho',
            'Julho',
            'Agosto',
            'Setembro',
            'Outubro',
            'Novembro',
            'Dezembro'
        );

        return $month[$month_number];
    }
}


