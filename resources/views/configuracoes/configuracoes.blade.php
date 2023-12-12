<x-layout>
    <x-slot:modal> </x-slot:modal>

    <x-slot:title> Importar fatos </x-slot:title>

    <x-slot:other_objects></x-slot:other_objects>

    <x-slot:container_form>
        <div class="container-fluid px-0">
            <div class="container-fluid CM mb-4">
                <div class="title-CM">Importar fatos</div>
                <form method="POST" action="{{ route('importar_Fatos') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md">
                            <div class="input-files-component">
                                <div class="input-group CM @error('file') is-invalid @enderror" id="xls_Fatos">
                                    <label for="upload-files" class="label-file pl-2 ml-1 pt-2 mt-1 text-muted"></label>
                                    <input type="file" class="form-control input-files" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="upload-files" name="file">
                                    <div class="input-group-append">    
                                        <label for="upload-files" class="btn btn-upl-CM m-1"> 
                                            <i class='bx bxs-cloud-upload btn-upl-icon-CM'></i>
                                            Escolha o arquivo excel para importação
                                        </label>
                                    </div>
                                </div>
                                @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="text-lg-right text-center mb-3">
                        <button type="reset" id="limpar_import" class="btn CM medium cancel-CM ml-1 mr-1 shadow-none"> Limpar </button>
                        <button type="submit" class="btn CM medium save-CM ml-2 shadow-none" id="importar_fatos" >
                            Importar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container-fluid side-by-side px-0">
            <div class="container-fluid CM side-by-side mb-6">
                <form method="POST" action="{{ route('adiciona_Fatos_Manual') }}" enctype="multipart/form-data" id="form_fatos_manual">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12 mb-0">
                            <div class="title-CM">Adicionar fato</div>
                        </div>
                        <div class="form-group col">
                            <label class="text-nowrap">Fato</label>
                            <input type="text" class="form-control CM" id="fato" name="fato" placeholder="Digite o fato">
                            <span class="invalid-feedback" id="tag_fato_invalido" role="alert"></span>
                        </div> 
                        <div class="form-group col">
                            <label class="text-nowrap">Grupo</label>
                            <div class="custom-selection grupo">
                                <select name="native-select" id="vs_grupo" data-search="true" data-silent-initial-value-set="true" hidden>
                                    @foreach ($grupos as $grupo)
                                        <option value={{ $grupo->id_grupo_fato }} >
                                            {{ $grupo->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert" id="tag_grupo_invalido"></span>
                            </div>
                        </div>
                        <div class="form-group col">
                            <label class="text-nowrap">Potencial ofensivo</label>
                            <div class="custom-selection envolvido-participacao" id="vs_potencial_ofensivo"></div>
                            <span class="invalid-feedback" id="tag_potencial_ofensivo_invalido" role="alert"></span>
                        </div>
                    </div>
                    <div class="text-lg-right text-center mb-3">
                        <button type="submit" class="btn CM medium save-CM ml-2 shadow-none" id="salvar_fato_manual" >
                            Inserir
                        </button>
                    </div>   
                </form>
            </div>
        </div>
    </x-slot:container_form>
</x-layout>