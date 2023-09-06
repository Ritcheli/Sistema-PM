<x-layout>
    <x-slot:modal>
        <x-modal-busca-pessoas></x-modal-busca-pessoas>
        <x-modal-pessoa></x-modal-pessoa>
        <x-modal-veiculo></x-modal-veiculo>
        <x-modal-busca-veiculo></x-modal-busca-veiculo>
    </x-slot:modal>

    @if ($Who_Call == 'Cad_Ocorrencia')
        <x-slot:title> Cadastro de ocorrências </x-slot:title>
    @endif
    @if ($Who_Call == 'Editar_Ocorrencia')
        <x-slot:title> Editar ocorrência </x-slot:title>
    @endif

    <x-slot:other_objects> </x-slot:other_objects>

    <x-slot:container_form>
        <div class="container-fluid px-0">
            <div class="container-fluid CM mb-4">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-envolvidos-tab" data-toggle="tab" data-target="#nav-envolvidos" type="button" role="tab" aria-controls="nav-envolvidos" aria-selected="true">Envolvidos</button>
                        <button class="nav-link" id="nav-veiculos-tab" data-toggle="tab" data-target="#nav-veiculos" type="button" role="tab" aria-controls="nav-veiculos" aria-selected="false">Veículos</button>
                        <button class="nav-link" id="nav-objetos-tab" data-toggle="tab" data-target="#nav-objetos" type="button" role="tab" aria-controls="nav-objetos" aria-selected="false">Objetos</button>
                        <button class="nav-link" id="nav-armas-tab" data-toggle="tab" data-target="#nav-armas" type="button" role="tab" aria-controls="nav-armas" aria-selected="false">Armas</button>
                        <button class="nav-link" id="nav-drogas-tab" data-toggle="tab" data-target="#nav-drogas" type="button" role="tab" aria-controls="nav-drogas" aria-selected="false">Drogas</button>
                        <button class="nav-link" id="nav-animais-tab" data-toggle="tab" data-target="#nav-animais" type="button" role="tab" aria-controls="nav-animais" aria-selected="false">Animais</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-envolvidos" role="tabpanel" aria-labelledby="nav-envolvidos-tab">
                        <form method="POST" action="{{ route('buscar_Pessoa_Ocorr_Modal') }}" id="form-envolvidos" class="form-tab">
                            <div class="title-CM">Envolvidos</div> 
                            <div class="form-row">
                                <div class="form-group col-md-12 mb-0">
                                    <label class="text-nowrap">Buscar</label>
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <input type="text" class="form-control CM" id="input-buscar" placeholder="Digite o nome do envolvido">
                                        </div> 
                                        <div class="form-group col-auto">
                                            <button type="submit" title="Buscar" id="search-pessoa" class="btn CM small search-CM shadow-none">
                                                <i class='bx bx-search btn-icon-CM'> </i>
                                            </button>
                                        </div>
                                        <div class="form-group col-auto">
                                            <button type="reset" title="Cadastrar novo" id="cad-pessoa" class="btn CM small add-CM shadow-none">
                                                <i class='bx bx-plus btn-icon-CM'></i>     
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <table class="table table-bordered CM mx-1 mb-3" id="table-pessoa">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="w-5">Id</th>
                                                    <th scope="col" class="w-50">Nome</th>
                                                    <th scope="col" class="w-30">CPF ou RG</th>
                                                    <th scope="col" class="w-10">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-body-pessoa">
                                                @if ($Who_Call == "Editar_Ocorrencia")
                                                    @foreach ($pessoas as $pessoa)
                                                        <tr class="envolvido">
                                                            <th scope="row" class="align-middle id-envolvido">
                                                                {{ $pessoa->id_pessoa }}
                                                            </th>
                                                            <td class="align-middle nome-envolvido">
                                                                {{ $pessoa->nome }}
                                                            </td>
                                                            <td class="align-middle RG-CPF-envolvido">
                                                                {{ $pessoa->RG_CPF }}
                                                            </td>
                                                            <td>
                                                                <div class="d-flex justify-content-between">
                                                                    <button type="button" value="{{ $pessoa->id_pessoa }}" title="Editar" class="btn btn-table-edit edit-pessoa w-45"> 
                                                                        <i class='bx bxs-edit btn-table-icon-CM'></i>
                                                                    </button>
                                                                    <button type="button" value="{{ $pessoa->id_pessoa }}" title="Remover" class="btn btn-table-remove btn-remove-from-table w-45"> 
                                                                        <i class='bx bxs-trash btn-table-icon-CM'></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div> 
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-veiculos" role="tabpanel" aria-labelledby="nav-veiculos-tab">
                        <form method="POST" action="{{ route('buscar_Veiculo_Modal') }}" id="form-veiculos-ocorr" class="form-tab">
                            @csrf
                            <div class="title-CM">Veículos</div> 
                            <div class="form-row">
                                <div class="form-group col-md-12 mb-0">
                                    <label class="text-nowrap">Buscar</label>
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <input type="text" class="form-control CM" id="input-buscar-veiculos" placeholder="Digite a placa do veículo">
                                        </div> 
                                        <div class="form-group col-auto">
                                            <button type="submit" title="Buscar" id="search-veiculos" class="btn CM small search-CM shadow-none">
                                                <i class='bx bx-search btn-icon-CM'> </i>
                                            </button>
                                        </div>
                                        <div class="form-group col-auto">
                                            <button type="reset" title="Cadastrar novo" id="cad-veiculo" class="btn CM small add-CM shadow-none">
                                                <i class='bx bx-plus btn-icon-CM'></i>     
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <table class="table table-bordered CM mx-1 mb-3" id="table-veiculo">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="w-10">Placa</th>
                                                    <th scope="col" class="w-25">Marca/Modelo</th>
                                                    <th scope="col" class="w-20">Cor</th>
                                                    <th scope="col" class="w-30">Participação</th>
                                                    <th scope="col" class="w-10">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-body-veiculo">
                                                @if ($Who_Call == 'Editar_Ocorrencia')
                                                    @foreach ($veiculos as $veiculo)
                                                        <tr class="veiculo">
                                                            <th scope="row" class="align-middle placa">
                                                                {{ $veiculo->placa }}
                                                            </th>
                                                            <td class="align-middle marca_modelo_veiculo">
                                                                {{ $veiculo->marca }}
                                                            </td>
                                                            <td class="align-middle cor_veiculo">
                                                                {{ $veiculo->cor }}
                                                            </td>
                                                            <td class="align-middle participacao">
                                                                {{ $veiculo->participacao }}
                                                            </td>
                                                            <td>
                                                                <div class="d-flex justify-content-between">
                                                                    <button type="button" value="{{ $veiculo->placa }}" title="Editar" class="btn btn-table-edit edit-veiculo w-45"> 
                                                                        <i class='bx bxs-edit btn-table-icon-CM'></i>
                                                                    </button>
                                                                    <button type="button" value="{{ $veiculo->id_veiculo }}" title="Remover" class="btn btn-table-remove btn-remove-from-table w-45"> 
                                                                        <i class='bx bxs-trash btn-table-icon-CM'></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div> 
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-objetos" role="tabpanel" aria-labelledby="nav-objetos-tab">
                        <x-form-objeto-diverso>
                            <x-slot:objetos_diversos>
                                @if ($Who_Call == 'Editar_Ocorrencia')
                                    @foreach ($objetos_diversos as $objeto_diverso)
                                        <tr class="objeto">
                                            <td scope="row" class="align-middle d-none num_identificacao">
                                                {{ $objeto_diverso->num_identificacao }}
                                            </td>
                                            <td scope="row" class="align-middle d-none id_objeto-diverso">
                                                {{ $objeto_diverso->id_objeto_diverso }}
                                            </td>
                                            <td scope="row" class="align-middle d-none objeto_objeto">
                                                {{ $objeto_diverso->objeto }}
                                            </td>
                                            <th scope="row" class="align-middle tipo_objeto">
                                                {{ $objeto_diverso->tipo }}
                                            </th>
                                            <td scope="row" class="align-middle marca_objeto">
                                                {{ $objeto_diverso->marca }}
                                            </td>
                                            <td scope="row" class="align-middle d-none un_med">
                                                {{ $objeto_diverso->un_medida }}
                                            </td>
                                            <td class="align-middle modelo_objeto">
                                                {{ $objeto_diverso->modelo }}
                                            </td>   
                                            <td class="align-middle quantidade">
                                                {{ $objeto_diverso->quantidade }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <button type="button" title="Editar" class="btn btn-table-edit edit-objeto w-45"> 
                                                        <i class='bx bxs-edit btn-table-icon-CM'></i>
                                                    </button>
                                                    <button type="button" title="Remover" class="btn btn-table-remove btn-remove-from-table w-45"> 
                                                        <i class='bx bxs-trash btn-table-icon-CM'></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </x-slot:objetos_diversos>
                        </x-form-objeto-diverso>
                    </div>
                    <div class="tab-pane fade show" id="nav-armas" role="tabpanel" aria-labelledby="nav-armas-tab">
                        <x-form-arma>
                            <x-slot:armas>
                                @if ($Who_Call == 'Editar_Ocorrencia')
                                    @foreach ($armas as $arma)
                                        <tr class="arma">
                                            <th scope="row" class="align-middle tipo_arma">
                                                {{ $arma->tipo }}
                                            </th>
                                            <td scope="row" class="align-middle especie_arma">
                                                {{ $arma->especie }}
                                            </td>
                                            <td scope="row" class="align-middle fabricacao_arma">
                                                {{ $arma->fabricacao }}
                                            </td>
                                            <td scope="row" class="align-middle calibre_arma">
                                                {{ $arma->calibre }}
                                            </td>
                                            <td scope="row" class="align-middle d-none num_serie_arma">
                                                {{ $arma->num_serie }}
                                            </td>
                                            <td scope="row" class="align-middle d-none id_arma">
                                                {{ $arma->id_arma }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <button type="button" title="Editar" class="btn btn-table-edit edit-arma w-45"> 
                                                        <i class='bx bxs-edit btn-table-icon-CM'></i>
                                                    </button>
                                                    <button type="button" title="Remover" class="btn btn-table-remove btn-remove-from-table w-45"> 
                                                        <i class='bx bxs-trash btn-table-icon-CM'></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </x-slot:armas>
                        </x-form-arma>
                    </div>
                    <div class="tab-pane fade" id="nav-drogas" role="tabpanel" aria-labelledby="nav-drogas-tab">
                        <x-form-droga>
                            <x-slot:drogas>
                                @if ($Who_Call == 'Editar_Ocorrencia')
                                    @foreach ($drogas as $droga)
                                        <tr class="droga">
                                            <th scope="row" class="align-middle tipo_droga">
                                                {{ $droga->tipo }}
                                            </th>
                                            <td scope="row" class="align-middle qtd_droga">
                                                {{ $droga->quantidade }}
                                            </td>
                                            <td scope="row" class="align-middle un_medida_droga">
                                                {{ $droga->un_medida }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <button type="button" title="Editar" class="btn btn-table-edit edit-droga w-45"> 
                                                        <i class='bx bxs-edit btn-table-icon-CM'></i>
                                                    </button>
                                                    <button type="button" title="Remover" class="btn btn-table-remove btn-remove-from-table w-45"> 
                                                        <i class='bx bxs-trash btn-table-icon-CM'></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </x-slot:drogas>
                        </x-form-droga>
                    </div>
                    <div class="tab-pane fade" id="nav-animais" role="tabpanel" aria-labelledby="nav-animais-tab">
                        <x-form-animal>
                            <x-slot:animais>
                                @if ($Who_Call == 'Editar_Ocorrencia')
                                    @foreach ($animais as $animal)
                                        <tr class="animal">
                                            <th scope="row" class="align-middle especie_animal">
                                                {{ $animal->especie }}
                                            </th>
                                            <td scope="row" class="align-middle qtd_animal">
                                                {{ $animal->quantidade }}
                                            </td>
                                            <td scope="row" class="align-middle participacao_animal">
                                                {{ $animal->participacao }}
                                            </td>
                                            <td scope="row" class="align-middle d-none outras_info_animal">
                                                {{ $animal->observacao }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <button type="button" title="Editar" class="btn btn-table-edit edit-animal w-45"> 
                                                        <i class='bx bxs-edit btn-table-icon-CM'></i>
                                                    </button>
                                                    <button type="button" title="Remover" class="btn btn-table-remove btn-remove-from-table w-45"> 
                                                        <i class='bx bxs-trash btn-table-icon-CM'></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </x-slot:animais>
                        </x-form-animal>
                    </div>
                </div>
            </div> 
            
            <div class="container-fluid CM mb-6">
            @if ($Who_Call == 'Cad_Ocorrencia')
                <form method="POST" action={{ route('nova_Ocorrencia') }} id="form_ocorrencia">
            @endif
            @if ($Who_Call == 'Editar_Ocorrencia')
                <form method="POST" action={{ route('editar_Ocorrencia') }} id="form_ocorrencia">
            @endif
                    @csrf
                    @if ($Who_Call == 'Cad_Ocorrencia')
                        <div class="title-CM">Nova ocorrência</div> 
                    @endif
                    @if ($Who_Call == 'Editar_Ocorrencia')
                        <div class="title-CM">Editar ocorrência</div> 
                    @endif
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Número do protocolo</label>
                            <input type="text" class="form-control CM" id="input_num_protocolo" name="input_num_protocolo" placeholder="Número protocolo" @if ($Who_Call == 'Editar_Ocorrencia') value="{{ $ocorrencia[0]->num_protocol }}" @endif>
                            <span class="invalid-feedback" role="alert" id="num_protocolo_invalido"></span>
                        </div> 
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Data do ocorrido</label>
                            <input type="datetime-local" class="form-control CM" id="input_data_hora" name="input_data_hora" placeholder="Data/Hora do ocorrido" @if ($Who_Call == 'Editar_Ocorrencia') value="{{ $ocorrencia[0]->data_hora }}" @endif>
                            <span class="invalid-feedback" role="alert" id="data_hora_invalida"></span>
                        </div> 
                        <div class="form-group col-md-12">
                            <label class="text-nowrap">Tipo ocorrência</label>
                            <div class="custom-selection tipo-ocorr" hidden>
                                <select name="native-select" id="tipo_ocorrencia" data-search="true" multiple data-silent-initial-value-set="true">
                                    @foreach ($fatos_ocorrencias as $fato_ocorrencia)
                                        <option value="{{ $fato_ocorrencia->id_fato_ocorrencia }}" 
                                            @if ($Who_Call == 'Editar_Ocorrencia')
                                                @foreach ($ocr_fatos_ocorrencias as $ocr_fato_ocorrencia)
                                                    @if ($ocr_fato_ocorrencia->id_fato_ocorrencia == $fato_ocorrencia->id_fato_ocorrencia) selected @endif 
                                                @endforeach
                                            @endif
                                            > {{ $fato_ocorrencia->natureza }} 
                                        </option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert" id="input_tipo_ocorrencia-invalido"></span>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="text-nowrap">CEP</label>
                            <input type="text" class="form-control CM" id="input_CEP" name="input_CEP" placeholder="CEP ocorrência"  @if ($Who_Call == 'Editar_Ocorrencia') value="{{ $ocorrencia[0]->endereco_cep }}" @endif>
                            <span class="invalid-feedback" role="alert" id="CEP_invalido"></span>
                        </div> 
                        <div class="form-group col-md-2">
                            <label class="text-nowrap">Estado</label>
                            <input type="text" class="form-control CM" id="input_estado" name="input_estado" placeholder="Estado/UF" @if ($Who_Call == 'Editar_Ocorrencia') value="{{ $endereco['estado'] }}" @endif>
                            <span class="invalid-feedback" role="alert" id="estado_invalido"></span>
                        </div> 
                        <div class="form-group col-md-8">
                            <label class="text-nowrap">Cidade</label>
                            <input type="text" class="form-control CM" id="input_cidade" name="input_cidade" placeholder="Cidade endereço ocorrência" @if ($Who_Call == 'Editar_Ocorrencia') value="{{ $endereco['cidade'] }}" @endif>
                            <span class="invalid-feedback" role="alert" id="cidade_invalida"></span>
                        </div> 
                        <div class="form-group col-md-4">
                            <label class="text-nowrap">Bairro</label>
                            <input type="text" class="form-control CM" id="input_bairro" name="input_bairro" placeholder="Bairro endereço ocorrência" @if ($Who_Call == 'Editar_Ocorrencia') value="{{ $endereco['bairro'] }}" @endif>
                            <span class="invalid-feedback" role="alert" id="bairro_invalido"></span>
                        </div> 
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Logradouro</label>
                            <input type="text" class="form-control CM" id="input_endereco_rua" name="input_endereco_rua" placeholder="Logradouro ocorrência" @if ($Who_Call == 'Editar_Ocorrencia') value="{{ $ocorrencia[0]->endereco_rua }}" @endif>
                            <span class="invalid-feedback" role="alert" id="rua_invalida"></span>
                        </div> 
                        <div class="form-group col-md-2">
                            <label class="text-nowrap">Número</label>
                            <input type="text" class="form-control CM" id="input_numero" name="input_numero" placeholder="Número endereço" @if ($Who_Call == 'Editar_Ocorrencia') value="{{ $ocorrencia[0]->endereco_num }}" @endif>
                            <span class="invalid-feedback" role="alert" id="numero_invalido"> teste</span>
                        </div>  
                        <div class="form-group col">
                            <label class="text-nowrap">Observações</label>
                            <div class="form-group mb-0">
                                <textarea class="CK_editor" id="descricao_ocor" name="descricao_ocor" placeholder="Digite a descrição da ocorrência"> @if ($Who_Call == 'Editar_Ocorrencia') {{ $ocorrencia[0]->descricao_ocorrencia }} @endif </textarea>
                                <span class="invalid-feedback" role="alert" id="descricao_invalida"> teste</span>
                            </div> 
                        </div>
                    </div>
                    <div class="text-lg-right text-center mb-2">
                        <button type="reset" id="cancelar-cad-ocorrencia" class="btn CM large cancel-CM ml-1 mr-1 shadow-none">Cancelar</button>
                        <button type="submit" class="btn CM large save-CM ml-1 shadow-none" id="salvar_ocorr" @if ($Who_Call == 'Editar_Ocorrencia') value="{{ $ocorrencia[0]->id_ocorrencia }}" @endif>Salvar</button>
                    </div>
                </form>
            </div>  
        </div>
    </x-slot:container_form>
</x-layout>

