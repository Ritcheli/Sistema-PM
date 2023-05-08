<x-layout>
    <x-slot:modal></x-slot:modal>

    <x-slot:title> Cadastro de usuários </x-slot:title>

    <x-slot:user> Ritcheli </x-slot:user>

    <x-slot:container_form>
        <div class="container-fluid CM rounded">
            <form method="POST" action="{{ route('novo_Usuario') }}">
                @csrf
                <div class="title-CM">Novo usuário</div> 
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <laber class="text-nowrap">Nome completo</laber class="text-nowrap">
                        <input type="text" class="form-control CM" name="nome_completo" id="nome_completo" placeholder="Digite seu nome completo">
                    </div> 
                    <div class="form-group col-md-12">
                        <laber class="text-nowrap">Nome de usuário</laber class="text-nowrap">
                        <input type="text" class="form-control CM" name="nome_usuario" id="=nome_usuario" placeholder="Digite seu nome de usuário">
                    </div> 
                    <div class="form-group col-md-6">
                        <laber class="text-nowrap">Email</laber class="text-nowrap">
                        <input type="email" class="form-control CM" name="email" id="email" placeholder="Digite seu CPF ou RG">
                    </div> 
                    <div class="form-group col-md-3">
                        <laber class="text-nowrap">CPF/RG</laber class="text-nowrap">
                        <input type="text" class="form-control CM" name="CPF_RG" id="CPF_RG" placeholder="Digite seu CPF ou RG">
                    </div> 
                    <div class="form-group col-md-3">
                        <laber class="text-nowrap">Nascimento</laber class="text-nowrap">
                        <input type="date" class="form-control CM" name="data_nasc" id="data_nasc" placeholder="Digite seu CPF ou RG">
                    </div> 
                    <div class="form-group col-md-6">
                        <laber class="text-nowrap">Senha</laber class="text-nowrap">
                        <input type="password" class="form-control CM" name="senha" id="senha" placeholder="Digite sua senha">
                    </div> 
                    <div class="form-group col-md-6">
                        <laber class="text-nowrap">Confirmar senha</laber class="text-nowrap">
                        <input type="password" class="form-control CM" name="confirma_senha" id="confirma_senha" placeholder="Digite sua senha novamente">
                    </div> 
                </div>
                <div class="text-md-right text-center">
                    <button type="reset" class="btn CM large cancel-CM ml-1 mr-1  shadow-none">Cancelar</button>
                    <button type="submit" class="btn CM large save-CM ml-1 mr-1 shadow-none">Salvar</button>
                </div>
            </form>
        </div> 
    </x-slot:container_form>
</x-layout>