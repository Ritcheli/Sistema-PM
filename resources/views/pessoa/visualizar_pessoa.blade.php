<x-layout>
    <x-slot:title>
        Visualizar pessoa
    </x-slot:title>

    <x-slot:modal></x-slot:modal>

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
                        Relatório de pessoas
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
                    <div class="form-row">
                        <div class="form-group col-ms-3 mr-2">
                            @if (count($fotos_pessoas) == 0)
                                <img src="{{ URL::asset('/img/no_image.png') }}" class="img-relatorio" alt="Imagem não encontrada">
                            @else
                                <div id="carouselExample" class="carousel slide" data-interval="false" data-ride="carousel">
                                    <div class="carousel-inner">
                                            @foreach ($fotos_pessoas as $foto_pessoa)
                                                @if ($foto_pessoa->id_foto_pessoa == $first[0]->first)
                                                    <div class="carousel-item active">
                                                        <img src={{ $foto_pessoa->caminho_servidor }} class="d-block img-relatorio" alt="Slide 1">
                                                    </div>
                                                @else
                                                    <div class="carousel-item">
                                                        <img src={{ $foto_pessoa->caminho_servidor }} class="d-block img-relatorio" alt="...">
                                                    </div>
                                                @endif
                                            @endforeach
                                        <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Anterior</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Próximo</span>
                                        </a>
                                        <ol class="carousel-indicators">
                                            @foreach ($fotos_pessoas as $foto_pessoa)
                                                @if ($foto_pessoa->id_foto_pessoa == $first[0]->first)
                                                    <li class="active"></li>
                                                @else
                                                    <li></li>
                                                @endif      
                                            @endforeach 
                                        </ol>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-md-3 mr-4 mb-4">
                            <div class="form-row">
                                <div class="title-infos mb-1"> Nome </div>
                            </div>
                            <div class="form-row mb-1">
                                <div> {{ $pessoa[0]->nome }} </div>
                            </div>
                            <div class="form-row">
                                <div class="title-infos mb-1"> Alcunha </div>
                            </div>
                            <div class="form-row mb-1">
                                @if ( $pessoa[0]->alcunha == "" )
                                    <div> Sem informações </div>
                                @else
                                    <div> {{ $pessoa[0]->alcunha }} </div>
                                @endif
                            </div>
                            <div class="form-row">
                                <div class="title-infos mb-1"> RG/CPF </div>
                            </div>
                            <div class="form-row mb-1">
                                @if ( $pessoa[0]->RG_CPF == "" )
                                    <div> Sem informações </div>
                                @else
                                    <div> {{ $pessoa[0]->RG_CPF }} </div>
                                @endif
                            </div>
                            <div class="form-row">
                                <div class="title-infos mb-1"> Telefone </div>
                            </div>
                            <div class="form-row">
                                @if ( $pessoa[0]->telefone == "" )
                                    <div> Sem informações </div>
                                @else
                                    <div> {{ $pessoa[0]->telefone }} </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-5 mr-4 mb-4">
                            <div class="form-row">
                                <div class="title-infos mb-1"> Data de nascimento </div>
                            </div>
                            <div class="form-row mb-1">
                                @if ( $pessoa[0]->data_nascimento == "" )
                                    <div> Sem informações </div>
                                @else
                                    <div> {{ $pessoa[0]->data_nascimento }} </div>
                                @endif
                            </div>
                            <div class="form-row">
                                <div class="title-infos mb-1"> Observação </div>
                            </div>
                            <div class="form-row text-justify">
                                <div> {{ strip_tags($pessoa[0]->observacao) }} </div>
                            </div>
                        </div>
                    </div>
                    @foreach ($ocorrencias as $ocorrencia)
                        <div class="row"> 
                            <hr class="solid"> 
                        </div>
                        <div class="row justify-content-center header-rel-ocorr"> 
                            Ocorrência
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
                                    <div> {{ $ocorrencia->num_protocol }} </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="title-infos">Data</div>
                                </div>
                                <div class="row">
                                    <div> {{ $ocorrencia->data }} </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="title-infos">Hora</div>
                                </div>
                                <div class="row">
                                    <div> {{ $ocorrencia->hora }} </div>
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
                                    <div> {{ $ocorrencia->endereco_cep }} </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="title-infos">Número</div>
                                </div>
                                @if ($ocorrencia->endereco_num == 0 )
                                    <div class="row">
                                        <div> Sem número </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div> {{ $ocorrencia->endereco_num }} </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="title-infos">Logradouro</div>
                                </div>
                                <div class="row">
                                    <div> {{ $ocorrencia->endereco_rua }} </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col"> 
                                <div class="row">
                                    <div class="title-infos">Bairro</div>
                                </div>
                                <div class="row">
                                    <div> {{ $ocorrencia->endereco_bairro }} </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="title-infos">Cidade</div>
                                </div>
                                <div class="row">
                                    <div> {{ $ocorrencia->endereco_cidade }} </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="title-infos">Estado</div>
                                </div>
                                <div class="row">
                                    <div> {{ $ocorrencia->endereco_estado }} </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </x-slot:container_form>
</x-layout>