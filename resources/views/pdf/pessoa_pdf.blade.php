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
                Relatório de pessoa
            </div>
            <div class="body-session-title-pdf">
                <strong> Informações gerais </strong> 
            </div>
            <table>
                <tr>
                    <td class="img-table-envolvidos" style="padding-top: 15px; vertical-align: top;">
                        @if ( $pessoa->caminho_servidor == "")
                            <img src="{{ public_path('img\no_image.png') }}" class="img-relatorio" alt="Imagem não encontrada">
                        @else
                            <img src= {{ public_path('uploads\\fotos_pessoas\\' . basename($pessoa->caminho_servidor)) }} class="img-relatorio" alt="">
                        @endif 
                    </td>
                    <td>
                        <table class="table-envolvidos">
                            <tr>
                                <td style="vertical-align: bottom; boder:solid 1px;"> <strong> Nome </strong> </td>
                            </tr>
                            <tr>
                                <td class="table-envolvidos-info"> {{ $pessoa->nome }} </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: bottom;"><strong> Alcunha</strong></td>
                            </tr>
                            <tr>
                                <td class="table-envolvidos-info"> 
                                    @if ($pessoa->alcunha == "")
                                        Sem informações
                                    @else
                                        {{ $pessoa->alcunha }} 
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: bottom;"><strong> RG/CPF </strong></td>
                            </tr>
                            <tr>
                                <td class="table-envolvidos-info"> 
                                    @if ($pessoa->RG_CPF == "")
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
                                    @if ($pessoa->telefone == "")
                                        Sem informações
                                    @else
                                        {{ $pessoa->telefone }} 
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class="content-table" style="margin-top: 0">
                <tr>
                    <td>
                        <strong> Data de nascimento </strong>
                    </td>
                    <td>
                        <strong> Observação </strong>
                    </td>
                </tr>
                <tr>
                    <td style="width: 225px; vertical-align: top;">
                        @if ($pessoa->data_nascimento == "")
                            Sem informações
                        @else
                            {{ $pessoa->data_nascimento }} 
                        @endif
                    </td>
                    <td style="width: 395px;"">
                        @if ($pessoa->observacao == "")
                            Sem informações
                        @else
                            {!! $pessoa->observacao !!} 
                        @endif
                    </td>
                </tr>
            </table>
            @foreach ($ocorrencias as $ocorrencia)
                <div class="body-session-title-pdf">
                    <strong> Ocorrência </strong> 
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
                            {{ $ocorrencia->fato_ocorrencia }}
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
                            {{ $ocorrencia->endereco_bairro }}
                        </td>
                        <td>
                            {{ $ocorrencia->endereco_cidade }}
                        </td>
                        <td>
                            {{ $ocorrencia->endereco_estado }}
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
            @endforeach
        </div>
    </main>
</body>