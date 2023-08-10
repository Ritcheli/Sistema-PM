<x-layout>
    <x-slot:modal>
        <x-modal-busca-pessoas></x-modal-busca-pessoas>
        <x-modal-pessoa></x-modal-pessoa>
    </x-slot:modal>

    @if ($Who_Call == 'Cad_Ocorrencia')
        <x-slot:title> Cadastro de ocorrências </x-slot:title>
    @endif
    @if ($Who_Call == 'Editar_Ocorrencia')
        <x-slot:title> Editar ocorrência </x-slot:title>
    @endif

    <x-slot:other_objects></x-slot:other_objects>

    <x-slot:container_form>
        <div class="container-fluid px-0">
            <div class="container-fluid CM mb-5">
                <form method="POST" action="{{ route('buscar_Pessoa_Ocorr_Modal') }}" id="form-envolvidos">
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

