<x-layout>
    <x-slot:modal></x-slot:modal>

    <x-slot:title>
        Importar Ocorrência
    </x-slot:title>

    <x-slot:other_objects></x-slot:other_objects>

    <x-slot:container_form>
        <div class="container-fluid px-0">
            <div class="container-fluid CM mb-4">
                <div class="title-CM">Importar ocorrência</div>
                <form method="POST" action="{{ route('importar_Ocorrencia') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md">
                            <div class="input-files-component">
                                <div class="input-group CM @error('files.*') is-invalid @enderror" id="pdf">
                                    <label for="upload-files" class="label-file pl-2 ml-1 pt-2 mt-1 text-muted"></label>
                                    <input type="file" class="form-control input-files" accept="application/pdf" id="upload-files" name="files[]" multiple>
                                    <div class="input-group-append">    
                                        <label for="upload-files" class="btn btn-upl-CM m-1"> 
                                            <i class='bx bxs-cloud-upload btn-upl-icon-CM'></i>
                                            Escolha um ou mais PDF(s) para importação
                                        </label>
                                    </div>
                                </div>
                                @error('files.*')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="text-lg-right text-center mb-3">
                        <button type="reset" id="limpar_import" class="btn CM medium cancel-CM ml-1 mr-1 shadow-none"> Limpar </button>
                        <button type="submit" class="btn CM medium save-CM ml-2 shadow-none" id="importar_ocorr" >
                            Importar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container-fluid CM mb-4">
            <div class="title-CM">Filtros</div>
            <form method="GET" action="{{ route('show_Importar_Ocorrencia') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label class="text-nowrap">Protocolo</label>
                        <input type="text" class="form-control CM" id="input_num_protocol" name="input_num_protocol"  value="{{ $num_protocol }}" placeholder="Número protocolo">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleFormControlSelect1"> Status </label>
                        <div class="custom-selection">
                            <div class="select-btn">
                                <span class="active"> @if ($revisado == "") Todos @else {{ $revisado }} @endif </span> 
                                <input type="text" class="input-custom-selection d-none" name="input_adicionado" @if ($revisado == "") value="Todos" @else value="{{ $revisado }}" @endif>
                                <i class='bx bx-chevron-down icon-select'></i>
                            </div>
                            <div class="content">
                                <ul class="options">
                                    <li class="option"> Todos </li>
                                    <li class="option"> Adicionado </li>
                                    <li class="option"> Não adicionado </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-5">
                        <label class="text-nowrap">Intervalo</label>
                        <div class="input-group input-daterange">
                            <input type="date" class="form-control CM initial-date" id="data_inicial_ocorr" name="data_inicial_ocorr" value="{{ $data_inicial }}" placeholder="Data inicial">
                            <div class="input-group-prepend">
                                <span class="input-group-text">até</span>
                            </div>
                            <input type="date" class="form-control CM final-date" id="data_final_ocorr" name="data_final_ocorr" value="{{ $data_final }}" placeholder="Data inicial">
                            </div>
                    </div>
                    <div class="form-group col-md">
                        <label class="text-nowrap">Descrição</label>
                        <input type="text" class="form-control CM" id="input_descricao" name="input_descricao" value="{{ $descricao }}" placeholder="Trecho da descrição">
                    </div>
                </div>
                <div class="text-lg-right text-center mb-3">
                    <button type="reset" id="limpar_filtros_ocorr_import" class="btn CM medium cancel-CM ml-1 mr-1 shadow-none"> Limpar </button>
                    <button type="submit" class="btn CM medium save-CM ml-2 shadow-none" id="buscar_ocorr" >
                        <i class='bx bx-search btn-icon-CM'></i>  
                        Buscar
                    </button>
                </div>
            </form>
        </div>
        <div class="container-fluid CM mb-6">
            <div class="form-row">
                <table class="table table-bordered CM mx-1 mb-3" id="table-pessoa">
                    <thead>
                        <tr>
                            <th scope="col" class="w-15">Num Protocolo</th>
                            <th scope="col" class="w-45">Descrição</th>
                            <th scope="col" class="w-10">Data/Hora</th>
                            <th scope="col" class="w-5">Adicionado</th>
                            <th scope="col" class="w-10">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="table-body-ocorrrencia">
                        @foreach ($ocorrencias_extraidas as $ocorrencia_extraida)
                        <tr>                         
                            <td scope="row" class="align-middle">
                                {{ $ocorrencia_extraida->num_protocol }} 
                            </td>
                            <td class="align-middle text-justify">
                                {!! substr(str_replace(array('<p>', '</p>'), "", $ocorrencia_extraida->descricao_ocorrencia), 0, 130) !!} 
                            </td>
                            <td scope="row" class="align-middle">
                                {{ $ocorrencia_extraida->data_hora }} 
                            </td>
                            <td class="align-middle text-center col-icon">
                                @if ($ocorrencia_extraida->revisado == "N")
                                <img height="30" width="30" src="http://localhost:8000/uploads/icons/cross.png" alt="">
                                @else
                                    <img height="25" width="25" src="http://localhost:8000/uploads/icons/check.png" alt="">
                                @endif
                            </td>
                            <td class="align-middle">
                                <div class="d-flex justify-content-between">
                                    <a type="button" value="" title="Editar" class="btn btn-table-edit w-45"  href= {{ route('show_Revisar_Ocorrencia', ['id_ocorrencia_extraida' => $ocorrencia_extraida->id_ocorrencia_extraida]) }}> 
                                        <i class='bx bxs-edit btn-table-icon-CM'></i>
                                    </a>
                                    <a type="button" title="Remover" class="btn btn-table-remove btn-remove-ocorr-extr w-45" value="{{ $ocorrencia_extraida->id_ocorrencia_extraida }} "> 
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
                {!! $ocorrencias_extraidas->onEachSide(1)->links() !!}
            </div>
        </div>
    </x-slot:container_form>
</x-layout>