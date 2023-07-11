<x-layout>
    <x-slot:modal></x-slot:modal>

    <x-slot:title> Visualizar Ocorrência </x-slot:title>

    <x-slot:container_form>
        <div class="container-fluid px-0">
            <div class="container-fluid CM mb-5">
                <div class="title-CM">Envolvidos</div> 
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
                            <div class="sub-title-CM mb-1"> Nome </div>
                        </div>
                        <div class="form-row mb-1">
                            <div class="content"> {{ $pessoa->nome }} </div>
                        </div>
                        <div class="form-row">
                            <div class="sub-title-CM mb-1"> Data de nascimento </div>
                        </div>
                        <div class="form-row mb-1">
                            @if ( $pessoa->data_nascimento == "" )
                                <div class="content"> Sem informações </div>
                            @else
                                <div class="content"> {{ $pessoa->data_nascimento }} </div>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="sub-title-CM mb-1"> RG/CPF </div>
                        </div>
                        <div class="form-row mb-1">
                            @if ( $pessoa->RG_CPF == "" )
                                <div class="content"> Sem informações </div>
                            @else
                                <div class="content"> {{ $pessoa->RG_CPF }} </div>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="sub-title-CM mb-1"> Telefone </div>
                        </div>
                        <div class="form-row">
                            @if ( $pessoa->telefone == "" )
                                <div class="content"> Sem informações </div>
                            @else
                                <div class="content"> {{ $pessoa->telefone }} </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="container-fluid px-0">
            <div class="container-fluid CM mb-5">
                <div class="title-CM">Informações gerais</div> 
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <div class="sub-title-CM"> Protocolo </div>
                        <div class="content"> {{  $ocorrencia[0]->num_protocol }} </div>
                    </div>
                    <div class="form-group col-md-5">
                        <div class="sub-title-CM"> Data </div>
                        <div class="content"> {{ $ocorrencia[0]->data }} </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="sub-title-CM"> Hora </div>
                        <div class="content"> {{ $ocorrencia[0]->hora }} </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="sub-title-CM"> Tipo da ocorrência </div>
                        <div class="text-justify"> Vender, entregar ou fornecer arma de fogo, acessório, munição ou explosivo a criança ou adolescente </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid CM mb-5">
                <div class="title-CM">Local do ocorrido</div> 
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <div class="sub-title-CM"> CEP </div>
                        <div class="content"> {{ $ocorrencia[0]->endereco_cep }} </div>
                    </div>
                    <div class="form-group col-md-5">
                        <div class="sub-title-CM"> Estado </div>
                        <div class="content"> {{ $endereco['estado'] }} </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="sub-title-CM"> Cidade </div>
                        <div class="content"> {{ $endereco['cidade'] }} </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="sub-title-CM"> Bairro </div>
                        <div class="content"> {{ $endereco['bairro'] }} </div>
                    </div>
                    <div class="form-group col-md-5">
                        <div class="sub-title-CM"> Logradouro </div>
                        <div class="content"> {{ $ocorrencia[0]->endereco_rua }} </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="sub-title-CM"> Número </div>
                        <div class="content"> {{ $ocorrencia[0]->endereco_num }} </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid CM mb-5">
                <div class="title-CM mt-3">Ocorrido</div> 
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div class="sub-title-CM"> Descrição inicial </div>
                        <div class="text-justify"> "Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."
                            "There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain..." </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="sub-title-CM"> Descrição </div>
                        <div class="text-justify"> {!! $ocorrencia[0]->descricao_ocorrencia !!} </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:container_form>
</x-layout>