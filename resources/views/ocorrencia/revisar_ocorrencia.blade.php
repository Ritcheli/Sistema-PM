<x-layout>
    <x-slot:modal>
        <x-modal-pessoa>
            <x-slot:fatos_ocorrencias>
                @foreach ($fatos_ocorrencias as $fato_ocorrencia)
                    <option value={{ $fato_ocorrencia->id_fato_ocorrencia }}>
                        {{ $fato_ocorrencia->natureza }}
                    </option>
                @endforeach
            </x-slot:fatos_ocorrencias>
        </x-modal-pessoa>
        <x-modal-busca-pessoas></x-modal-busca-pessoas>
        <x-modal-veiculo></x-modal-veiculo>
        <x-modal-busca-veiculo></x-modal-busca-veiculo>
    </x-slot:modal>

    <x-slot:title>
        Revisar Ocorrência
    </x-slot:title>

    <x-slot:other_objects>
        <div class="menu-collapse">
            <div class="d-flex justify-content-between"> 
                <div class="title-CM">PDF original</div> 
                
                <a data-toggle="collapse" href="#colapse_PDF" aria-controls="collapseExample">
                    <i class="bx bx-menu collapse-button"></i>
                </a> 
            </div>
            <div class="collapse" id="colapse_PDF">
                <embed src={{ $ocorrencia_extraida[0]->pdf_caminho_servidor }} type="application/pdf" width="100%" height="400vh">
            </div>
        </div>
    </x-slot:other_objects>

    <x-slot:container_form>
        <div class="container-fluid px-0 pt-7">
            <div class="container-fluid CM mb-4">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        @if ($ocorrencia_extraida[0]->possui_envolvidos == "S")
                            <button class="nav-link active" id="nav-envolvidos-tab" data-toggle="tab" data-target="#nav-envolvidos" type="button" role="tab" aria-controls="nav-envolvidos" aria-selected="true">Envolvidos</button>
                        @endif
                        @if ($ocorrencia_extraida[0]->possui_veiculos == "S")
                            <button class="nav-link" id="nav-veiculos-tab" data-toggle="tab" data-target="#nav-veiculos" type="button" role="tab" aria-controls="nav-veiculos" aria-selected="false">Veículos</button>
                        @endif
                        @if ($ocorrencia_extraida[0]->possui_objetos == "S")
                            <button class="nav-link" id="nav-objetos-tab" data-toggle="tab" data-target="#nav-objetos" type="button" role="tab" aria-controls="nav-objetos" aria-selected="false">Objetos</button>
                        @endif
                        @if ($ocorrencia_extraida[0]->possui_armas == "S")
                            <button class="nav-link" id="nav-armas-tab" data-toggle="tab" data-target="#nav-armas" type="button" role="tab" aria-controls="nav-armas" aria-selected="false">Armas</button>
                        @endif
                        @if ($ocorrencia_extraida[0]->possui_drogas == "S")
                            <button class="nav-link" id="nav-drogas-tab" data-toggle="tab" data-target="#nav-drogas" type="button" role="tab" aria-controls="nav-drogas" aria-selected="false">Drogas</button>
                        @endif
                        @if ($ocorrencia_extraida[0]->possui_animais == "S")
                            <button class="nav-link" id="nav-animais-tab" data-toggle="tab" data-target="#nav-animais" type="button" role="tab" aria-controls="nav-animais" aria-selected="false">Animais</button>
                        @endif
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    @if ($ocorrencia_extraida[0]->possui_envolvidos == "S")
                        <div class="tab-pane fade show active" id="nav-envolvidos" role="tabpanel" aria-labelledby="nav-envolvidos-tab">
                            <form method="POST" action="{{ route('buscar_Pessoa_Ocorr_Modal') }}" id="form-envolvidos" class="form-tab @if ($ocorrencia_extraida[0]->revisado == 'S') disabled @endif">
                                @csrf
                                <div class="title-CM">Envolvidos</div>
                                <div class="form-row">
                                    <div class="form-group col-md-12 mb-0">
                                        <label class="text-nowrap">Buscar</label>
                                        <div class="form-row">
                                            <div class="form-group col">
                                                <input type="text" class="form-control CM" id="input-buscar-envolvidos" placeholder="Digite o nome do envolvido">
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
                                                        <th scope="col" class="w-30">RG ou CPF</th>
                                                        <th scope="col" class="d-none">Fato_Participacao</th>
                                                        <th scope="col" class="w-10">Ações</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table-body-pessoa">
                                                    @foreach ($pessoas as $pessoa)
                                                        <tr class="envolvido">
                                                            <th scope="row" class="align-middle id-envolvido">
                                                                {{ $pessoa->id_pessoa }}
                                                            </th>
                                                            <td class="align-middle nome-envolvido">
                                                                {{ $pessoa->nome }}
                                                            </td>
                                                            <td class="align-middle RG_CPF-envolvido">
                                                                {{ $pessoa->RG_CPF }}
                                                            </td>
                                                            <td class="align-middle participacao-envolvido d-none">
                                                                {{ $pessoa->participacao }}
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
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> 
                                </div>
                            </form>
                        </div>
                    @endif
                    @if ($ocorrencia_extraida[0]->possui_veiculos == "S")
                        <div class="tab-pane fade show" id="nav-veiculos" role="tabpanel" aria-labelledby="nav-veiculos-tab">
                            <form method="POST" action="{{ route('buscar_Veiculo_Modal') }}" id="form-veiculos-ocorr" class="form-tab  @if ($ocorrencia_extraida[0]->revisado == 'S') disabled @endif">
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
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> 
                                </div>
                            </form>
                        </div>
                    @endif
                    @if ($ocorrencia_extraida[0]->possui_objetos == "S")
                        <div class="tab-pane fade show" id="nav-objetos" role="tabpanel" aria-labelledby="nav-objetos-tab">
                            <div class="@if ($ocorrencia_extraida[0]->revisado == 'S') disabled @endif">
                                <x-form-objeto-diverso>
                                    <x-slot:tipos_objetos>
                                        @foreach ($tipos_objetos as $tipo_objeto)
                                            <option value="{{ $tipo_objeto->objeto }}"> {{ $tipo_objeto->objeto }} </option>
                                        @endforeach    
                                    </x-slot:tipos_objetos>   
                                    <x-slot:objetos_diversos>
                                        @foreach ($objetos_diversos as $objeto_diverso)
                                            <tr class="objeto">
                                                <td scope="row" class="align-middle d-none num_identificacao">
                                                    {{ $objeto_diverso->num_identificacao }}
                                                </td>
                                                <td scope="row" class="align-middle d-none id_objeto-diverso">
                                                    {{ $objeto_diverso->id_objeto_diverso }}
                                                </td>
                                                <th scope="row" class="align-middle tipo_objeto">
                                                    {{ $objeto_diverso->objeto }}
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
                                                <td class="align-middle">
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
                                    </x-slot:objetos_diversos>
                                </x-form-objeto-diverso>
                            </div>
                        </div>
                    @endif
                    @if ($ocorrencia_extraida[0]->possui_armas == "S")
                        <div class="tab-pane fade show" id="nav-armas" role="tabpanel" aria-labelledby="nav-armas-tab">
                            <div class="@if ($ocorrencia_extraida[0]->revisado == 'S') disabled @endif">
                                <x-form-arma>
                                    <x-slot:armas>
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
                                    </x-slot:armas>
                                </x-form-arma>
                            </div>
                        </div>
                    @endif
                    @if ($ocorrencia_extraida[0]->possui_drogas == "S")
                        <div class="tab-pane fade show" id="nav-drogas" role="tabpanel" aria-labelledby="nav-drogas-tab">
                            <div class="@if ($ocorrencia_extraida[0]->revisado == 'S') disabled @endif">
                                <x-form-droga>
                                    <x-slot:drogas>
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
                                    </x-slot:drogas>
                                </x-form-droga>
                            </div>
                        </div>
                    @endif
                    @if ($ocorrencia_extraida[0]->possui_animais == "S")
                        <div class="tab-pane fade show" id="nav-animais" role="tabpanel" aria-labelledby="nav-animais-tab">
                            <div class="@if ($ocorrencia_extraida[0]->revisado == 'S') disabled @endif">
                                <x-form-animal>
                                    <x-slot:animais>
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
                                    </x-slot:animais>
                                </x-form-animal>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="@if ($ocorrencia_extraida[0]->revisado == 'S') disabled @endif">
            <div class="container-fluid CM mb-6 mt-4" value="{{ $ocorrencia_extraida[0]->id_ocorrencia_extraida }}">
                <form method="POST" action="{{ route("nova_Ocorrencia_Revisada") }}" id="form_ocorrencia_revisada" value="{{ $ocorrencia_extraida[0]->id_ocorrencia_extraida }}">
                    <div class="title-CM">Ocorrência</div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Número do protocolo</label>
                            <input type="text" class="form-control CM" id="input_num_protocolo" name="input_num_protocolo" value="{{ $ocorrencia_extraida[0]->num_protocol }}" placeholder="Número protocolo">
                            <span class="invalid-feedback" role="alert" id="input_num_protocolo-invalido"></span>
                        </div> 
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Data do ocorrido</label>
                            <input type="datetime-local" class="form-control CM" id="input_data_hora" name="input_data_hora" value="{{ $ocorrencia_extraida[0]->data_hora }}" placeholder="Data/Hora do ocorrido">
                            <span class="invalid-feedback" role="alert" id="input_data_hora-invalida"></span>
                        </div> 
                        <div class="form-group col-md-12">
                            <label class="text-nowrap">Tipo ocorrência</label>
                            <div class="custom-selection tipo-ocorr-ext" hidden>
                                <select name="native-select" id="tipo_ocorrencia_extraida" data-search="true" multiple data-silent-initial-value-set="true">
                                    @foreach ($fatos_ocorrencias as $fato_ocorrencia)
                                        <option value={{ $fato_ocorrencia->id_fato_ocorrencia }}
                                        @foreach ($ocr_ext_fatos_ocorrencias as $ocr_ext_fato_ocorrencia)
                                             @if ($ocr_ext_fato_ocorrencia->id_fato_ocorrencia == $fato_ocorrencia->id_fato_ocorrencia) selected @endif 
                                        @endforeach
                                        >
                                            {{ $fato_ocorrencia->natureza }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert" id="input_tipo_ocorrencia-invalido"></span>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="text-nowrap">CEP</label>
                            <input type="text" class="form-control CM" id="input_CEP" name="input_CEP" value="{{ $ocorrencia_extraida[0]->endereco_cep }}" placeholder="CEP ocorrência">
                            <span class="invalid-feedback" role="alert" id="input_CEP-invalido"></span>
                        </div> 
                        <div class="form-group col-md-2">
                            <label class="text-nowrap">Estado</label>
                            <input type="text" class="form-control CM" id="input_estado" name="input_estado" value="{{ $ocorrencia_extraida[0]->estado }}" placeholder="Estado/UF">
                            <span class="invalid-feedback" role="alert" id="input_estado-invalido"></span>
                        </div> 
                        <div class="form-group col-md-8">
                            <label class="text-nowrap">Cidade</label>
                            <input type="text" class="form-control CM" id="input_cidade" name="input_cidade" value="{{ $ocorrencia_extraida[0]->cidade }}" placeholder="Cidade endereço ocorrência">
                            <span class="invalid-feedback" role="alert" id="input_cidade-invalida"></span>
                        </div> 
                        <div class="form-group col-md-4">
                            <label class="text-nowrap">Bairro</label>
                            <input type="text" class="form-control CM" id="input_bairro" name="input_bairro" value="{{ $ocorrencia_extraida[0]->bairro }}" placeholder="Bairro endereço ocorrência">
                            <span class="invalid-feedback" role="alert" id="input_bairro-invalido"></span>
                        </div> 
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Logradouro</label>
                            <input type="text" class="form-control CM" id="input_rua" name="input_rua" value="{{ $ocorrencia_extraida[0]->endereco_rua }}" placeholder="Logradouro ocorrência">
                            <span class="invalid-feedback" role="alert" id="input_rua-invalido"></span>
                        </div> 
                        <div class="form-group col-md-2">
                            <label class="text-nowrap">Número</label>
                            <input type="text" class="form-control CM" id="input_numero" name="input_numero" value="{{ $ocorrencia_extraida[0]->endereco_num }}" placeholder="Número endereço">
                            <span class="invalid-feedback" role="alert" id="input_numero-invalido"></span>
                        </div>  
                        <div class="form-group col-md-12">
                            <label class="text-nowrap">Descrição inicial</label>
                            <div class="form-group mb-0">
                                <textarea class="CK_editor" id="descricao_inicial_ocor_import" name="descricao_inicial_ocor_import" placeholder="Digite a descrição da ocorrência"> {{ $ocorrencia_extraida[0]->descricao_inicial }} </textarea>
                                <span class="invalid-feedback" role="alert" id="descricao_inicial_ocor_import-invalida"> </span>
                            </div> 
                        </div>
                        <div class="form-group col">
                            <label class="text-nowrap">Descrição</label>
                            <div class="form-group mb-0">
                                <textarea class="CK_editor" id="descricao_ocor_import" name="descricao_ocor_import" placeholder="Digite a descrição da ocorrência"> {{ $ocorrencia_extraida[0]->descricao_ocorrencia }} </textarea>
                                <span class="invalid-feedback" role="alert" id="descricao_ocor_import-invalida"></span>
                            </div> 
                        </div>
                    </div>
                    @if ($ocorrencia_extraida[0]->revisado == 'N')  
                        <div class="text-lg-right text-center mb-2">
                            <button type="reset" id="cancelar-cad-ocorrencia" class="btn CM large cancel-CM ml-1 mr-1 shadow-none">Cancelar</button>
                            <button type="submit" class="btn CM large save-CM ml-1 shadow-none" id="salvar_import_ocorr">Salvar</button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </x-slot:container_form>
</x-layout>