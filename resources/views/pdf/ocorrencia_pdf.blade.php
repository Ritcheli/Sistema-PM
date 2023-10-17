<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title id="page-title" > Impressão de ocorrência </title>
    <link rel="stylesheet" href="{{ public_path('css\impressao_PDF.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body class="bg-white body-pdf">
    <!-- Define header and footer blocks before your content -->
    <header class="header-pdf">
        <table class="header-table">
            <tr>
                <td class="header-table-td">
                    <img src="{{ public_path('img\logo-pm-sc.png') }}" class="header-img" alt="">
                </td>
                <td class="header-table-td header-text">
                    <strong>
                        Polícia Militar de Santa Catarina
                        <br>
                        19º Batalhão de Polícia Militar
                        <br>
                        Araranguá - SC
                    </strong> 
                </td>
            </tr>
        </table>
    </header>

    <footer class="footer-pdf">
        Página <span class="pagenum"></span>
    </footer>

    <main>
        <div style="page-break-inside: auto;">
            <div class="body-title-pdf">
                Relatório de ocorrência
            </div>
            <div class="body-session-title-pdf">
                <strong> Informações gerais </strong> 
            </div>
            <table class="content-table">
                <tr class="content-table-td-3">
                    <td>
                        <strong> Num protocolo </strong>
                    </td>
                    <td>
                        <strong> Data </strong>
                    </td>
                    <td>
                        <strong> Hora </strong>
                    </td>
                </tr>
                <tr class="content-table-td-3">
                    <td>
                        {{ $ocorrencia->num_protocol }}
                    </td>
                    <td>
                        {{ $ocorrencia->data }}
                    </td>
                    <td>
                        {{ $ocorrencia->hora }}
                    </td>
                </tr>
            </table>
            <table class="content-table">
                <tr class="content-table-td-1">
                    <td>
                        <strong> Fato ocorrência </strong>
                    </td>
                </tr>
                <tr class="content-table-td-1">
                    <td>
                       {{ $fatos[0]->fato_ocorrencia }}
                    </td>
                </tr>
            </table>
            <table class="content-table">
                <tr class="content-table-td-3">
                    <td>
                        <strong> CEP </strong>
                    </td>
                    <td>
                        <strong> Número </strong>
                    </td>
                    <td>
                        <strong> Logradouro </strong>
                    </td>
                </tr>
                <tr class="content-table-td-3">
                    <td>
                        {{ $ocorrencia->endereco_cep }}
                    </td>
                    <td>
                        {{ $ocorrencia->endereco_num }}
                    </td>
                    <td>
                        {{ $ocorrencia->endereco_rua }}
                    </td>
                </tr>
            </table>
            <table class="content-table">
                <tr class="content-table-td-3">
                    <td>
                        <strong> Bairro </strong>
                    </td>
                    <td>
                        <strong> Cidade </strong>
                    </td>
                    <td>
                        <strong> Estado </strong>
                    </td>
                </tr>
                <tr class="content-table-td-3">
                    <td>
                        {{ $endereco['bairro'] }}
                    </td>
                    <td>
                        {{ $endereco['cidade'] }}
                    </td>
                    <td>
                        {{ $endereco['estado'] }}
                    </td>
                </tr>
            </table>
            <table class="content-table">
                <tr class="content-table-td-3">
                    <td>
                        <strong> Descrição inicial </strong>
                    </td>
                </tr>
            </table>
            <div class="content-desc-pdf">
                @if ($ocorrencia->descricao_inicial == "")
                    <div> Sem descrição inicial </div>
                @else
                    <div> {{ strip_tags($ocorrencia->descricao_inicial) }} </div>
                @endif
            </div>
            <table class="content-table">
                <tr class="content-table-td-3">
                    <td>
                        <strong> Descrição </strong>
                    </td>
                </tr>
            </table>
            <div class="content-desc-pdf">
                @if ($ocorrencia->descricao_ocorrencia == "")
                    <div> Sem descrição inicial </div>
                @else
                    <div> {!! strip_tags($ocorrencia->descricao_ocorrencia) !!} </div>
                @endif
            </div>
            @if (count($pessoas) > 0)
                <div class="body-session-title-pdf">
                    <strong> Envolvidos </strong> 
                </div>
                @foreach ($pessoas as $pessoa)
                    <table>
                        <tr>
                            <td class="img-table-envolvidos">
                                @if ( $pessoa->caminho_servidor == "")
                                    <img src="{{ public_path('img\no_image.png') }}" class="img-relatorio" alt="Imagem não encontrada">
                                @else
                                    <img src= {{ public_path('uploads\\fotos_pessoas\\' . basename($pessoa->caminho_servidor)) }} class="img-relatorio" alt="">
                                @endif 
                            </td>
                            <td>
                                <table class="table-envolvidos">
                                    <tr>
                                        <td style="vertical-align: bottom;"> <strong> Nome </strong> </td>
                                    </tr>
                                    <tr>
                                        <td class="table-envolvidos-info"> {{ $pessoa->nome }} </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: bottom;"><strong> Data de Nascimento</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="table-envolvidos-info">
                                        @if ( $pessoa->data_nascimento == "" )
                                                Sem informações 
                                        @else
                                            {{ $pessoa->data_nascimento }}
                                        @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: bottom;"><strong> RG/CPF </strong></td>
                                    </tr>
                                    <tr>
                                        <td class="table-envolvidos-info">
                                            @if ( $pessoa->RG_CPF == "" )
                                                Sem informações 
                                            @else
                                                {{ $pessoa->RG_CPF }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: bottom;"><strong> Telefone </strong></td>
                                    </tr>
                                    <tr>
                                        <td class="table-envolvidos-info">
                                            @if ( $pessoa->telefone == "" )
                                                <div> Sem informações </div>
                                            @else
                                                <div> {{ $pessoa->telefone }} </div>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                @endforeach
            @endif
            @if (count($veiculos) > 0)
                @foreach ($veiculos as $veiculo)
                    <div class="body-session-title-pdf">
                        <strong> Veículos </strong> 
                    </div>
                    <table class="content-table">
                        <tr class="content-table-td-4">
                            <td>
                                <strong> Placa </strong>
                            </td>
                            <td>
                                <strong> Cor </strong>
                            </td>
                            <td>
                                <strong> Renavam </strong>
                            </td>
                            <td>
                                <strong> Chassi </strong>
                            </td>
                        </tr>
                        <tr class="content-table-td-4">
                            <td>
                                {{ $veiculo->placa }}
                            </td>
                            <td>
                                {{ $veiculo->cor }}
                            </td>
                            <td>
                                {{ $veiculo->renavam }}
                            </td>
                            <td>
                                {{ $veiculo->chassi }}
                            </td>
                        </tr>
                    </table>
                    <table class="content-table">
                        <tr class="content-table-td-2">
                            <td>
                                <strong> Marca </strong>
                            </td>
                            <td>
                                <strong> Participação </strong>
                            </td>
                        </tr>
                        <tr class="content-table-td-2">
                            <td>
                                {{ $veiculo->marca }}
                            </td>
                            <td>
                                {{ $veiculo->participacao }}
                            </td>
                        </tr>
                    </table>
                @endforeach 
            @endif
            @if (count($objetos_diversos) > 0)
                @foreach ($objetos_diversos as $objetos_diverso)
                    <div class="body-session-title-pdf">
                        <strong> Objeto diverso </strong> 
                    </div>
                    <table class="content-table">
                        <tr class="content-table-td-3">
                            <td>
                                <strong> Num identificação </strong>
                            </td>
                            <td>
                                <strong> Modelo </strong>
                            </td>
                            <td>
                                <strong> Marca </strong>
                            </td>
                        </tr>
                        <tr class="content-table-td-3">
                            <td>
                                {{ $objetos_diverso->num_identificacao }}
                            </td>
                            <td>
                                {{ $objetos_diverso->modelo }}
                            </td>
                            <td>
                                {{ $objetos_diverso->marca }}
                            </td>
                        </tr>
                    </table>
                    <table class="content-table">
                        <tr class="content-table-td-3">
                            <td>
                                <strong> Tipo </strong>
                            </td>
                            <td>
                                <strong> Un Medida </strong>
                            </td>
                            <td>
                                <strong> Quantidade </strong>
                            </td>
                            <td></td>
                        </tr>
                        <tr class="content-table-td-4">
                            <td>
                                {{ $objetos_diverso->objeto }} 
                            </td>
                            <td>
                                {{ $objetos_diverso->un_medida }}
                            </td>
                            <td>
                                {{ $objetos_diverso->quantidade }}
                            </td>
                            <td></td>
                        </tr>
                    </table>
                @endforeach
            @endif
            @if (count($armas) > 0)
                @foreach ($armas as $arma)
                <div class="body-session-title-pdf">
                    <strong> Arma </strong> 
                </div>
                <table class="content-table">
                    <tr class="content-table-td-3">
                        <td>
                            <strong> Tipo </strong>
                        </td>
                        <td>
                            <strong> Num série </strong>
                        </td>
                        <td>
                            <strong> Calibre </strong>
                        </td>
                    </tr>
                    <tr class="content-table-td-3">
                        <td>
                            {{ $arma->tipo }}
                        </td>
                        <td>
                            {{ $arma->num_serie }}
                        </td>
                        <td>
                            {{ $arma->calibre }}
                        </td>
                    </tr>
                </table>
                <table class="content-table">
                    <tr class="content-table-td-3">
                        <td>
                            <strong> Espécie </strong>
                        </td>
                        <td>
                            <strong> Fabricação </strong>
                        </td>
                        <td></td>
                    </tr>
                    <tr class="content-table-td-3">
                        <td>
                            {{ $arma->especie }}
                        </td>
                        <td>
                            {{ $arma->fabricacao }}
                        </td>
                        <td></td>
                    </tr>
                </table>
                @endforeach
            @endif
            @if (count($drogas) > 0)
                @foreach ($drogas as $droga)
                <div class="body-session-title-pdf">
                    <strong> Substância </strong> 
                </div>
                <table class="content-table">
                    <tr class="content-table-td-3">
                        <td>
                            <strong> Tipo </strong>
                        </td>
                        <td>
                            <strong> Num série </strong>
                        </td>
                        <td>
                            <strong> Calibre </strong>
                        </td>
                    </tr>
                    <tr class="content-table-td-3">
                        <td>
                            {{ $droga->tipo }}
                        </td>
                        <td>
                            {{ $droga->quantidade }}
                        </td>
                        <td>
                            {{ $droga->un_medida }}
                        </td>
                    </tr>
                </table>
                @endforeach
            @endif
            @if (count($animais) > 0)
                @foreach ($animais as $animal)
                <div class="body-session-title-pdf">
                    <strong> Animal </strong> 
                </div>
                <table class="content-table">
                    <tr class="content-table-td-3">
                        <td>
                            <strong> Espécie </strong>
                        </td>
                        <td>
                            <strong> Quantidade </strong>
                        </td>
                        <td>
                            <strong> Participação </strong>
                        </td>
                    </tr>
                    <tr class="content-table-td-3">
                        <td>
                            {{ $animal->especie }}
                        </td>
                        <td>
                            {{ $animal->quantidade }}
                        </td>
                        <td>
                            {{ $animal->participacao }}
                        </td>
                    </tr>
                </table>
                <table class="content-table">
                    <tr class="content-table-td-3">
                        <td>
                            <strong> Observação </strong>
                        </td>
                    </tr>
                    <tr class="content-table-td-3">
                        <td>
                            {{ $animal->observacao }}
                        </td>
                    </tr>
                </table>  
                @endforeach
            @endif
        </div>
    </main>
</body>