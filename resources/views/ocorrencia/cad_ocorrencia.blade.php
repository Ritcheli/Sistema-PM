<x-layout>
    <x-slot:title> Cadastro de ocorrências </x-slot:title>
    
    <x-slot:user> Ritcheli </x-slot:user>

    <x-slot:container_form>
            <div class="container-fluid">
                <form method="POST">
                    <div class="title">Nova ocorrência</div> 
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Número do protocolo</label>
                            <input type="text" class="form-control" id="input_num_protocolo" placeholder="Digite o número de protocolo">
                        </div> 
                        <div class="form-group col-md-4">
                            <label>Data do ocorrido</label>
                            <input type="date" class="form-control" id="input_data_ocorrencia" placeholder="Digite a data do ocorrido">
                        </div> 
                        <div class="form-group col-md-12">
                            <label>Nome de usuário</label>
                            <input type="text" class="form-control" id="input_nome_usuario" placeholder="Digite seu nome de usuário">
                        </div> 
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="email" class="form-control" id="input_email" placeholder="Digite seu CPF ou RG">
                        </div> 
                        <div class="form-group col-md-3">
                            <label>CPF/RG</label>
                            <input type="text" class="form-control" id="input_CPF_RG" placeholder="Digite seu CPF ou RG">
                        </div> 
                        <div class="form-group col-md-6">
                            <label>Senha</label>
                            <input type="password" class="form-control" id="input_senha" placeholder="Digite sua senha">
                        </div> 
                        <div class="form-group col-md-6">
                            <label>Confirmar senha</label>
                            <input type="password" class="form-control" id="input_confirm_senha" placeholder="Digite sua senha novamente">
                        </div> 
                    </div>
                    <div class="text-md-right text-center">
                        <button type="reset" class="btn cancel-CM shadow-none">Cancelar</button>
                        <button type="submit" class="btn save-CM shadow-none">Salvar</button>
                    </div>
                </form>
            </div> 
    </x-slot:container_form>
</x-layout>