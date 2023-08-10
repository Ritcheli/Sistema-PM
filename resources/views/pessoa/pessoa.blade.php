<x-layout>
    <x-slot:modal></x-slot:modal>

    <x-slot:title> 
    @if ($Who_Call == "Cad_Pessoa")
        Cadastrar pessoa 
    @endif
    @if ($Who_Call == "Editar_Pessoa")
        Editar pessoa
    @endif
    </x-slot:title>

    <x-slot:other_objects></x-slot:other_objects>

    <x-slot:container_form>
        <div class="container-fluid px-0">
            <div class="container-fluid CM mb-5">
                @if ($Who_Call == "Cad_Pessoa")
                    <div class="title-CM">Nova pessoa</div> 
                @endif
                @if ($Who_Call == "Editar_Pessoa")
                    <div class="title-CM">Editar pessoa</div> 
                @endif
                @if ($Who_Call == "Cad_Pessoa")
                    <form method="POST" action="{{ route('nova_Pessoa') }}" enctype="multipart/form-data">
                        @csrf
                @endif
                @if ($Who_Call == "Editar_Pessoa")
                    <form method="POST" action="{{ route('salvar_Edit_Pessoa') }}" enctype="multipart/form-data">
                        @csrf
                        <input class="d-none" type="text" value="{{ $pessoa[0]->id_pessoa }}" id="Who_Call" name="id_pessoa">
                @endif
                        <input class="d-none" type="text" value="Pessoa" id="Who_Call" name="Who_Call">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="text-nowrap">Nome</label>
                                <input type="text" class="form-control CM @error('nome') is-invalid @enderror" id="nome" name="nome" placeholder="Digite o nome" @if ($Who_Call == "Editar_Pessoa") value="{{ $pessoa[0]->nome }}" @else value="{{ old('nome') }}" @endif>
                                @error('nome')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div> 
                            <div class="form-group col-md-4">
                                <label class="text-nowrap">CPF/RG</label>
                                <input type="text" class="form-control CM @error('CPF_RG') is-invalid @enderror" id="CPF_RG" name="CPF_RG" placeholder="Digite o CPF ou RG"  @if ($Who_Call == "Editar_Pessoa") value="{{ $pessoa[0]->RG_CPF }}" @else value="{{ old('CPF_RG') }}" @endif">
                                @error('CPF_RG')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label class="text-nowrap">Telefone</label>
                                <input type="text" class="form-control CM @error('telefone') is-invalid @enderror" id="telefone" name="telefone" placeholder="Digite o telefone"  @if ($Who_Call == "Editar_Pessoa") value="{{ $pessoa[0]->telefone }}" @else value="{{ old('telefone') }}" @endif">
                                @error('telefone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label class="text-nowrap">Data de nascimento</label>
                                <input type="date" class="form-control CM" id="data_nascimento" name="data_nascimento" @if ($Who_Call == "Editar_Pessoa") value="{{ $pessoa[0]->data_nascimento }}" @else value="{{ old('data_nascimento') }}" @endif>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-nowrap">Alcunha</label>
                                <input type="text" class="form-control CM @error('alcunha') is-invalid @enderror" id="alcunha" name="alcunha" placeholder="Digite a alcunha"  @if ($Who_Call == "Editar_Pessoa") value="{{ $pessoa[0]->alcunha }}" @else value="{{ old('alcunha') }}" @endif>
                                @error('alcunha')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> 
                        <div class="upload-img-component">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label class="text-nowrap">Fotos</label>
                                    <div class="input-group CM @error('files.*') is-invalid @enderror" id="foto">
                                        <label for="upload" class="label-foto pl-2 ml-1 pt-2 mt-1 text-muted"></label>
                                        <input type="file" class="form-control input-foto" accept="image/png, image/jpg, image/jpeg" id="upload" name="files[]" multiple>
                                        <div class="input-group-append">    
                                            <label for="upload" class="btn btn-upl-CM m-1"> 
                                                <i class='bx bxs-cloud-upload btn-upl-icon-CM'></i>
                                                Escolha uma ou mais fotos
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
                            <div class="form-row">
                                <div class="form-group col">
                                    <div class="rounded img-preview p-3"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="text-nowrap">Observações</label>
                                <div class="form-group mb-0">
                                    <textarea class="CK_editor" id="observacao_pessoa" name='observacao_pessoa' placeholder="Digite a observação da pessoa"> @if ($Who_Call == "Editar_Pessoa") {{ $pessoa[0]->observacao }} @else {{ old('observacao') }} @endif </textarea>
                                    <span class="invalid-feedback" role="alert" id="observacao_pessoa-invalido">  </span>
                                </div> 
                            </div>
                        </div>
                        <div class="text-md-right text-center mb-2 mt-1">
                            @if ($Who_Call == "Cad_Pessoa")
                                <a class="text-decoration-none" href="{{ route('show_Dashboard') }}">
                            @endif
                            @if ($Who_Call == "Editar_Pessoa")
                                <a class="text-decoration-none" href="{{ route('show_Busca_Pessoa') }}">
                            @endif
                                    <button type="button" id="cancelar-cad-pessoa" class="btn CM large cancel-CM ml-1 mr-1 shadow-none"> Cancelar </button>
                                </a>
                                <button type="submit" class="btn CM large save-CM ml-1 shadow-none"> Salvar </button>
                        </div> 
                </form>  
            </div>
        </div>
    </x-slot:container_form>
</x-layout>
