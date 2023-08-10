<x-layout>
    <x-slot:modal></x-slot:modal>

    <x-slot:title> Visualizar Ocorrência </x-slot:title>

    <x-slot:other_objects></x-slot:other_objects>

    <x-slot:container_form>
        <div class="container-fluid px-0">
            <div class="container-fluid CM mb-5">
                <div class="container" id="testee">
                    <div class="row d-flex justify-content-center">
                        <img src="http://localhost:8000/img/logo-pm-sc.png" alt="">
                    </div>
                    <div class="row d-flex justify-content-center mt-3 header-rel-ocorr">
                        Polícia militar de Santa Catarina
                    </div>
                    <div class="row d-flex justify-content-center header-rel-ocorr">
                        19º Batalhão da Polícia Militar
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
                                <div class="title-infos">Fato ocorrência</div>
                            </div>
                            <div class="row">
                                <div> Roubo </div>
                            </div>
                            {{-- <div class="row">
                                <div> {{ $fatos[0]->natureza }}</div>
                            </div> --}}
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
                    <div class="row mt-2 mb-0">
                        <div class="col"> 
                            <div class="row">
                                <div class="title-infos">Descrição inicial</div>
                            </div>
                            <div class="row">
                                <div> {{ strip_tags($ocorrencia[0]->descricao_inicial) }} </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <div class="row text-justify">
                                <div class="title-infos">Descrição</div>
                            </div>
                            <div class="row text-justify">
                                <div> {{ strip_tags($ocorrencia[0]->descricao_ocorrencia) }} </div>
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <hr class="solid"> 
                    </div>
                    <div class="row justify-content-center header-rel-ocorr"> 
                        Envolvidos
                    </div>
                    <div class="row"> 
                        <hr class="solid"> 
                    </div>
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
                </div>
            </div>

            <div class="container-fluid CM mb-5">
                <div class="title-CM">Imprimir PDF</div> 
                <div class="form-row">
                    <button class="btn CM medium save-CM ml-2 shadow-none" id="pdfLALA"> PDF </button>
                </div>
            </div>
        </div>
    </x-slot:container_form>
</x-layout>