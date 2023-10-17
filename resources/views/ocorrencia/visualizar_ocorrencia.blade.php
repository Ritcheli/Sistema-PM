<x-layout>
    <x-slot:modal></x-slot:modal>

    <x-slot:title> Visualizar Ocorrência </x-slot:title>

    <x-slot:other_objects></x-slot:other_objects>

    <x-slot:container_form>
        <div class="container-fluid px-0">
            <div class="btn-pdf">  
                <a class="content" href="{{ route('create_PDF_Ocorrencia', ['id_ocorrencia' => $ocorrencia[0]->id_ocorrencia]) }}" target="_blank">
                    <i class='bx bxs-file-pdf'></i>
                </a>
            </div>
            <div class="container-fluid CM mb-5 pb-5">
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <img src="http://localhost:8000/img/logo-pm-sc.png" alt="">
                    </div>
                    <div class="row d-flex justify-content-center mt-3 header-rel-ocorr">
                        Polícia Militar de Santa Catarina
                    </div>
                    <div class="row d-flex justify-content-center header-rel-ocorr">
                        19º Batalhão de Polícia Militar
                    </div>
                    <div class="row d-flex justify-content-center header-rel-ocorr">
                        Araranguá - SC
                    </div>
                    <div class="row mt-5 justify-content-center title-rel-ocorr">
                        Relatório de ocorrência
                    </div>
                    <div class="row mt-4"> 
                        <hr class="solid"> 
                    </div>
                    <div class="row justify-content-center header-rel-ocorr"> 
                        Informações gerais 
                    </div>
                    <div class="row"> 
                        <hr class="solid"> 
                    </div>
                    <div class="row">
                        <div class="col"> 
                            <div class="row">
                                <div class="title-infos">Num Protocolo</div>
                            </div>
                            <div class="row">
                                <div> {{ $ocorrencia[0]->num_protocol }} </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="title-infos">Data</div>
                            </div>
                            <div class="row">
                                <div> {{ $ocorrencia[0]->data }} </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="title-infos">Hora</div>
                            </div>
                            <div class="row">
                                <div> {{ $ocorrencia[0]->hora }} </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col"> 
                            <div class="row">
                                <div class="title-infos">Fato Ocorrência</div>
                            </div>
                            <div class="row">
                                <div> {{ $fatos[0]->fato_ocorrencia }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col"> 
                            <div class="row">
                                <div class="title-infos">CEP</div>
                            </div>
                            <div class="row">
                                <div> {{ $ocorrencia[0]->endereco_cep }} </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="title-infos">Número</div>
                            </div>
                            @if ($ocorrencia[0]->endereco_num == 0 )
                                <div class="row">
                                    <div> Sem número </div>
                                </div>
                            @else
                                <div class="row">
                                    <div> {{ $ocorrencia[0]->endereco_num }} </div>
                                </div>
                            @endif
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="title-infos">Logradouro</div>
                            </div>
                            <div class="row">
                                <div> {{ $ocorrencia[0]->endereco_rua }} </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col"> 
                            <div class="row">
                                <div class="title-infos">Bairro</div>
                            </div>
                            <div class="row">
                                <div> {{ $endereco['bairro'] }} </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="title-infos">Cidade</div>
                            </div>
                            <div class="row">
                                <div> {{ $endereco['cidade'] }} </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="title-infos">Estado</div>
                            </div>
                            <div class="row">
                                <div> {{ $endereco['estado'] }} </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col"> 
                            <div class="row">
                                <div class="title-infos">Descrição Inicial</div>
                            </div>
                            <div class="row">
                                @if ($ocorrencia[0]->descricao_inicial == "")
                                    <div> Sem descrição inicial </div>
                                @else
                                    <div> {{ strip_tags($ocorrencia[0]->descricao_inicial) }} </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <div class="row text-justify">
                                <div class="title-infos">Descrição</div>
                            </div>
                            <div class="row text-justify">
                                <div> {!! ($ocorrencia[0]->descricao_ocorrencia) !!}  </div>
                            </div>
                        </div>
                    </div>
                    @if (count($pessoas) > 0)
                        <div class="row"> 
                            <hr class="solid"> 
                        </div>
                        <div class="row justify-content-center header-rel-ocorr"> 
                            Envolvidos
                        </div>
                        <div class="row"> 
                            <hr class="solid"> 
                        </div>
                    @endif
                    <div class="form-row">
                        @foreach ($pessoas as $pessoa)
                        <div class="form-group col-ms-3 mr-2">
                            @if ( $pessoa->caminho_servidor == "")
                                <img src="{{ URL::asset('/img/no_image.png') }}" class="img-relatorio" alt="Imagem não encontrada">
                            @else
                                <img src= {{ $pessoa->caminho_servidor }} class="img-relatorio" alt="">
                            @endif    
                        </div>
                        <div class="form-group col-md-3 mr-4 mb-4">
                            <div class="form-row">
                                <div class="title-infos mb-1"> Nome </div>
                            </div>
                            <div class="form-row mb-1">
                                <div> {{ $pessoa->nome }} </div>
                            </div>
                            <div class="form-row">
                                <div class="title-infos mb-1"> Data de nascimento </div>
                            </div>
                            <div class="form-row mb-1">
                                @if ( $pessoa->data_nascimento == "" )
                                    <div> Sem informações </div>
                                @else
                                    <div> {{ $pessoa->data_nascimento }} </div>
                                @endif
                            </div>
                            <div class="form-row">
                                <div class="title-infos mb-1"> RG/CPF </div>
                            </div>
                            <div class="form-row mb-1">
                                @if ( $pessoa->RG_CPF == "" )
                                    <div> Sem informações </div>
                                @else
                                    <div> {{ $pessoa->RG_CPF }} </div>
                                @endif
                            </div>
                            <div class="form-row">
                                <div class="title-infos"> Telefone </div>
                            </div>
                            <div class="form-row">
                                @if ( $pessoa->telefone == "" )
                                    <div> Sem informações </div>
                                @else
                                    <div> {{ $pessoa->telefone }} </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @foreach ($veiculos as $veiculo)
                        <div class="row"> 
                            <hr class="solid"> 
                        </div>
                        <div class="row justify-content-center header-rel-ocorr"> 
                            Veículo
                        </div>
                        <div class="row"> 
                            <hr class="solid"> 
                        </div>
                        <div class="row mt-2">
                            <div class="col"> 
                                <div class="row">
                                    <div class="title-infos">Placa</div>
                                </div>
                                <div class="row">
                                    <div> {{ $veiculo->placa }} </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="title-infos">Cor</div>
                                </div>
                                <div class="row">
                                    <div> {{ $veiculo->cor }} </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="title-infos">Renavam</div>
                                </div>
                                <div class="row">
                                    <div> {{ $veiculo->renavam }} </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="title-infos">Chassi</div>
                                </div>
                                <div class="row">
                                    <div> {{ $veiculo->chassi }} </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3"> 
                                <div class="row">
                                    <div class="title-infos">Marca</div>
                                </div>
                                <div class="row">
                                    <div> {{ $veiculo->marca }} </div>
                                </div>
                            </div>
                            <div class="col"> 
                                <div class="row">
                                    <div class="title-infos">Participação</div>
                                </div>
                                <div class="row">
                                    <div> {{ $veiculo->participacao }} </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @foreach ($objetos_diversos as $objeto_diverso)
                        <div class="row"> 
                            <hr class="solid"> 
                        </div>
                        <div class="row justify-content-center header-rel-ocorr"> 
                            Objeto diverso
                        </div>
                        <div class="row"> 
                            <hr class="solid"> 
                        </div>
                        <div class="row mt-2">
                            <div class="col"> 
                                <div class="row">
                                    <div class="title-infos">Tipo</div>
                                </div>
                                <div class="row">
                                    <div> {{ $objeto_diverso->objeto }} </div>

                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="title-infos">Num identificação</div>
                                </div>
                                <div class="row">
                                    <div> {{ $objeto_diverso->num_identificacao }} </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="title-infos">Modelo</div>
                                </div>
                                <div class="row">
                                    <div> {{ $objeto_diverso->modelo }} </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="title-infos">Marca</div>
                                </div>
                                <div class="row">
                                    <div> {{ $objeto_diverso->marca }} </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3"> 
                                <div class="row">
                                    <div class="title-infos">Un medida</div>
                                </div>
                                <div class="row">
                                    <div> {{ $objeto_diverso->un_medida }} </div>
                                </div>
                            </div>
                            <div class="col-3"> 
                                <div class="row">
                                    <div class="title-infos">Quantidade</div>
                                </div>
                                <div class="row">
                                    <div> {{ $objeto_diverso->quantidade }} </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @foreach ($armas as $arma)
                        <div class="row"> 
                            <hr class="solid"> 
                        </div>
                        <div class="row justify-content-center header-rel-ocorr"> 
                            Arma
                        </div>
                        <div class="row"> 
                            <hr class="solid"> 
                        </div>
                        <div class="row mt-2">
                            <div class="col"> 
                                <div class="row">
                                    <div class="title-infos">Tipo</div>
                                </div>
                                <div class="row">
                                    <div> {{ $arma->tipo }} </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="title-infos">Num série</div>
                                </div>
                                <div class="row">
                                    <div> {{ $arma->num_serie }} </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="title-infos">Calibre</div>
                                </div>
                                <div class="row">
                                    <div> {{ $arma->calibre }} </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4"> 
                                <div class="row">
                                    <div class="title-infos">Espécie</div>
                                </div>
                                <div class="row">
                                    <div> {{ $arma->especie }} </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="title-infos">Fabricação</div>
                                </div>
                                <div class="row">
                                    <div> {{ $arma->fabricacao }} </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @foreach ($drogas as $droga)
                        <div class="row"> 
                            <hr class="solid"> 
                        </div>
                        <div class="row justify-content-center header-rel-ocorr"> 
                            Substância
                        </div>
                        <div class="row"> 
                            <hr class="solid"> 
                        </div>
                        <div class="row mt-2">
                            <div class="col"> 
                                <div class="row">
                                    <div class="title-infos">Tipo</div>
                                </div>
                                <div class="row">
                                    <div> {{ $droga->tipo }} </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="title-infos">Quantidade</div>
                                </div>
                                <div class="row">
                                    <div> {{ $droga->quantidade }} </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="title-infos">Un medida</div>
                                </div>
                                <div class="row">
                                    <div> {{ $droga->un_medida }} </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @foreach ($animais as $animal)
                        <div class="row"> 
                            <hr class="solid"> 
                        </div>
                        <div class="row justify-content-center header-rel-ocorr"> 
                            Animal
                        </div>
                        <div class="row"> 
                            <hr class="solid"> 
                        </div>
                        <div class="row mt-2">
                            <div class="col"> 
                                <div class="row">
                                    <div class="title-infos">Espécie</div>
                                </div>
                                <div class="row">
                                    <div> {{ $animal->especie }} </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="title-infos">Quantidade</div>
                                </div>
                                <div class="row">
                                    <div> {{ $animal->quantidade }} </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="title-infos">Participação</div>
                                </div>
                                <div class="row">
                                    <div> {{ $animal->participacao }} </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <div class="row">
                                    <div class="title-infos">Observação</div>
                                </div>
                                <div class="row">
                                    <div> {{ $animal->observacao }} </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </x-slot:container_form>
</x-layout>