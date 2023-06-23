<x-layout>
    <x-slot:modal></x-slot:modal>

    <x-slot:title> Consulta de ocorrências </x-slot:title>

    <x-slot:container_form>
        <div class="container-fluid px-0">
            <div class="container-fluid CM mb-4">
                <form method="GET" action=" {{ route('show_Busca_Ocorrencia') }} ">
                    <div class="title-CM">Filtros</div> 
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label class="text-nowrap">Protocolo</label>
                            <input type="text" class="form-control CM" id="input_num_protocol" name="input_num_protocol" value="{{ $num_protocol }}" placeholder="Número protocolo">
                        </div>
                        <div class="form-group col-md-9">
                            <label class="text-nowrap">Descrição</label>
                            <input type="text" class="form-control CM" id="input_descricao" name="input_descricao" value="{{ $descricao }}" placeholder="Trecho da descrição">
                        </div>
                        <div class="form-group col-md-7">
                            <label class="text-nowrap">Envolvido</label>
                            <input type="text" class="form-control CM" id="input_pessoa" name="input_pessoa" value="{{ $pessoa }}" placeholder="Nome do envolvido">
                        </div>
                        <div class="form-group col-md-5">
                            <label class="text-nowrap">Intervalo</label>
                            <div class="input-group input-daterange mb-3">
                                <input type="date" class="form-control CM initial-date" id="data_inicial_ocorr" name="data_inicial_ocorr" value="{{ $data_inicial }}" placeholder="Data inicial">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">até</span>
                                </div>
                                <input type="date" class="form-control CM final-date" id="data_final_ocorr" name="data_final_ocorr" value="{{ $data_final }}" placeholder="Data inicial">
                                </div>
                        </div>
                    </div>
                    <div class="text-lg-right text-center mb-3">
                        <button type="reset" id="limpar_filtros" class="btn CM medium cancel-CM ml-1 mr-1 shadow-none"> Limpar </button>
                        <button type="submit" class="btn CM medium save-CM ml-2 shadow-none" id="buscar_ocorr" >
                            <i class='bx bx-search btn-icon-CM'></i>  
                            Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container-fluid CM mb-6">
            <div class="form-row">
                <table class="table table-bordered CM mx-1 mb-3" id="table-pessoa">
                    <thead>
                        <tr>
                            <th scope="col" class="w-13">Num Protocolo</th>
                            <th scope="col" class="w-30">Descrição</th>
                            <th scope="col" class="w-20">Envolvidos</th>
                            <th scope="col" class="w-15">Data/Hora</th>
                            <th scope="col" class="w-15">Ações</th>
                        </tr>
                    </thead>
                    @foreach ($ocorrencias as $ocorrencia)
                    <tbody id="table-body-pessoa">
                        <tr class="envolvido">
                            <td scope="row" class="align-middle id-envolvido">
                                {{ $ocorrencia->num_protocol }}
                            </td>
                            <td class="align-middle nome-envolvido">
                                {{ substr(strip_tags($ocorrencia->descricao_ocorrencia), 0, 130) }} 
                            </td>
                            <td scope="row" class="align-middle id-envolvido">
                                {{ $ocorrencia->pessoas_envolvidas }}
                            </td>
                            <td class="align-middle RG-CPF-envolvido">
                                {{ $ocorrencia->data_hora }}
                            </td>
                            <td class="align-middle">
                                <div class="d-flex justify-content-between">
                                    <a type="button" value="" title="Visualizar" class="btn btn-table-view w-30" href= {{ route('show_Visualizar_Ocorrencia', ['id_ocorrencia' => $ocorrencia->id_ocorrencia]) }}> 
                                        <i class='bx bx-show btn-table-icon-CM'></i>
                                    </a>
                                    <a type="button" value="" title="Editar" class="btn btn-table-edit w-30"> 
                                        <i class='bx bxs-edit btn-table-icon-CM'></i>
                                    </a>
                                    <a type="button" value="" title="Remover" class="btn btn-table-remove w-30"> 
                                        <i class='bx bxs-trash btn-table-icon-CM'></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {!! $ocorrencias->onEachSide(1)->links() !!}
            </div>
        </div>
    </x-slot:container_form>
</x-layout>