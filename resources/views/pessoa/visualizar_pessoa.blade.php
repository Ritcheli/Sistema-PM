<x-layout>
    <x-slot:title>
        Visualizar pessoa
    </x-slot:title>

    <x-slot:modal></x-slot:modal>

    <x-slot:container_form>
        <div class="container-fluid px-0">
            <div class="container-fluid CM mb-5">
                <div class="title-CM">Pessoa</div>
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
                            <div class="sub-title-CM mb-1"> Nome </div>
                        </div>
                        <div class="form-row mb-1">
                            <div class="content"> {{ $pessoa[0]->nome }} </div>
                        </div>
                        <div class="form-row">
                            <div class="sub-title-CM mb-1"> Alcunha </div>
                        </div>
                        <div class="form-row mb-1">
                            @if ( $pessoa[0]->alcunha == "" )
                                <div class="content"> Sem informações </div>
                            @else
                                <div class="content"> {{ $pessoa[0]->alcunha }} </div>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="sub-title-CM mb-1"> RG/CPF </div>
                        </div>
                        <div class="form-row mb-1">
                            @if ( $pessoa[0]->RG_CPF == "" )
                                <div class="content"> Sem informações </div>
                            @else
                                <div class="content"> {{ $pessoa[0]->RG_CPF }} </div>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="sub-title-CM mb-1"> Telefone </div>
                        </div>
                        <div class="form-row">
                            @if ( $pessoa[0]->telefone == "" )
                                <div class="content"> Sem informações </div>
                            @else
                                <div class="content"> {{ $pessoa[0]->telefone }} </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group col-md-5 mr-4 mb-4">
                        <div class="form-row">
                            <div class="sub-title-CM mb-1"> Data de nascimento </div>
                        </div>
                        <div class="form-row mb-1">
                            @if ( $pessoa[0]->data_nascimento == "" )
                                <div class="content"> Sem informações </div>
                            @else
                                <div class="content"> {{ $pessoa[0]->data_nascimento }} </div>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="sub-title-CM mb-1"> Observação </div>
                        </div>
                        <div class="form-row text-justify">
                            <div class="content"> {!! $pessoa[0]->observacao !!} </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:container_form>
</x-layout>