<x-layout>
    <x-slot:title> Cadastro de usuários </x-slot:title>

    <x-slot:user> Ritcheli </x-slot:user>

    <x-slot:container_form>
        <div class="container-fluid CM rounded">
            <form>
                <div class="title">Novo usuário</div> 
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <laber class="text-nowrap">Nome completo</laber class="text-nowrap">
                        <input type="text" class="form-control CM" id="input_nome_completo" placeholder="Digite seu nome completo">
                    </div> 
                    <div class="form-group col-md-12">
                        <laber class="text-nowrap">Nome de usuário</laber class="text-nowrap">
                        <input type="text" class="form-control CM" id="input_nome_usuario" placeholder="Digite seu nome de usuário">
                    </div> 
                    <div class="form-group col-md-6">
                        <laber class="text-nowrap">Email</laber class="text-nowrap">
                        <input type="email" class="form-control CM" id="input_email" placeholder="Digite seu CPF ou RG">
                    </div> 
                    <div class="form-group col-md-3">
                        <laber class="text-nowrap">CPF/RG</laber class="text-nowrap">
                        <input type="text" class="form-control CM" id="input_CPF_RG" placeholder="Digite seu CPF ou RG">
                    </div> 
                    <div class="form-group col-md-3">
                        <laber class="text-nowrap">Nascimento</laber class="text-nowrap">
                        <input type="date" class="form-control CM" id="input_data_nasc" placeholder="Digite seu CPF ou RG">
                    </div> 
                    <div class="form-group col-md-6">
                        <laber class="text-nowrap">Senha</laber class="text-nowrap">
                        <input type="password" class="form-control CM" id="input_senha" placeholder="Digite sua senha">
                    </div> 
                    <div class="form-group col-md-6">
                        <laber class="text-nowrap">Confirmar senha</laber class="text-nowrap">
                        <input type="password" class="form-control CM" id="input_confirm_senha" placeholder="Digite sua senha novamente">
                    </div> 
                </div>
                <div class="text-md-right text-center">
                    <button type="reset" class="btn CM cancel-CM shadow-none">Cancelar</button>
                    <button type="submit" class="btn CM save-CM shadow-none">Salvar</button>
                </div>
            </form>
        </div> 
    </x-slot:container_form>
</x-layout>