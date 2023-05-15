<x-layout>
    <x-slot:modal></x-slot:modal>

    <x-slot:title> Cadastro de usuários </x-slot:title>

    <x-slot:user> Ritcheli </x-slot:user>

    <x-slot:container_form>
        <div class="container-fluid CM mb-5 rounded">
            <form method="POST" action="{{ route('novo_Usuario') }}">
                @csrf
                <div class="title-CM">Novo usuário</div> 
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="text-nowrap">Nome completo</label>
                        <input type="text" class="form-control CM @error('nome_completo') is-invalid @enderror" name="nome_completo" id="nome_completo" placeholder="Digite seu nome completo" value="{{ old('nome_completo') }}">
                        @error('nome_completo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                    <div class="form-group col-md-12">
                        <label class="text-nowrap">Nome de usuário</label>
                        <input type="text" class="form-control CM  @error('nome_usuario') is-invalid @enderror" name="nome_usuario" id="nome_usuario" placeholder="Digite seu nome de usuário" value="{{ old('nome_usuario') }}">
                        @error('nome_usuario')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                    <div class="form-group col-md-6">
                        <label class="text-nowrap">Email</label>
                        <input type="email" class="form-control CM @error('email') is-invalid @enderror" name="email" id="email" placeholder="Digite seu email" value="{{ old('email') }}">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                    <div class="form-group col-md-3">
                        <label class="text-nowrap">CPF/RG</label>
                        <input type="text" class="form-control CM @error('CPF_RG') is-invalid @enderror" name="CPF_RG" id="CPF_RG" placeholder="Digite seu CPF ou RG" value="{{ old('CPF_RG') }}">
                        @error('CPF_RG')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                    <div class="form-group col-md-3">
                        <label class="text-nowrap">Nascimento</label>
                        <input type="date" class="form-control CM @error('data_nasc') is-invalid @enderror" name="data_nasc" id="data_nasc" value="{{ old('data_nasc') }}">
                        @error('data_nasc')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                    <div class="form-group col-md-6">
                        <label class="text-nowrap">Senha</label>
                        <input type="password" autocomplete="new-password" class="form-control CM @error('senha') is-invalid @enderror" name="senha" id="senha" placeholder="Digite sua senha" value="{{ old('senha') }}">
                        @error('senha')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                    <div class="form-group col-md-6">
                        <label class="text-nowrap">Confirmar senha</label>
                        <input type="password" class="form-control CM @error('confirma_senha') is-invalid @enderror" name="confirma_senha" id="confirma_senha" placeholder="Digite sua senha novamente" value="{{ old('confirma_senha') }}">
                        @error('confirma_senha')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                </div>
                <div class="text-md-right text-center">
                    <button type="reset" class="btn CM large cancel-CM ml-1 mr-1 mb-1 shadow-none">Cancelar</button>
                    <button type="submit" class="btn CM large save-CM ml-1 mb-1 shadow-none">Salvar</button>
                </div>
            </form>
        </div> 
    </x-slot:container_form>
</x-layout>