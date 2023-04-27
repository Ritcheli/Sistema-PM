<x-layout>
    <x-slot:title> Cadastro de ocorrências </x-slot:title>
    
    <x-slot:user> Ritcheli </x-slot:user>

    <x-slot:container_form>
        <div class="container-fluid px-0 ">
            <div class="container-fluid CM mb-5 rounded">
                <form>
                    <div class="title-CM">Nova ocorrência</div> 
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label class="text-nowrap"> Número do protocolo</label>
                            <input type="text" class="form-control CM" id="input_num_protocolo" placeholder="Digite o número de protocolo">
                        </div> 
                        <div class="form-group col-md-4">
                            <label class="text-nowrap">Data do ocorrido</label>
                            <input type="date" class="form-control CM" id="input_data_ocorrencia" placeholder="Digite a data do ocorrido">
                        </div> 
                        <div class="form-group col-md-12">
                            <label class="text-nowrap">Nome de usuário</label>
                            <input type="text" class="form-control CM" id="input_nome_usuario" placeholder="Digite seu nome de usuário">
                        </div> 
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Email</label>
                            <input type="email" class="form-control CM" id="input_email" placeholder="Digite seu CPF ou RG">
                        </div> 
                        <div class="form-group col-md-3">
                            <label class="text-nowrap">CPF/RG</label>
                            <input type="text" class="form-control CM" id="input_CPF_RG" placeholder="Digite seu CPF ou RG">
                        </div> 
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Senha</label>
                            <input type="password" class="form-control CM" id="input_senha" placeholder="Digite sua senha">
                        </div> 
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Confirmar senha</label>
                            <input type="password" class="form-control CM" id="input_confirm_senha" placeholder="Digite sua senha novamente">
                        </div> 
                    </div>
                </form>
            </div> 
            <div class="container-fluid CM mb-5 rounded">
                <form>
                    <div class="title-CM">Nova ocorrência</div> 
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label class="text-nowrap">Número do protocolo</label>
                            <input type="text" class="form-control CM" id="input_num_protocolo" placeholder="Digite o número de protocolo">
                        </div> 
                        <div class="form-group col-md-4">
                            <label class="text-nowrap">Data do ocorrido</label>
                            <input type="date" class="form-control CM" id="input_data_ocorrencia" placeholder="Digite a data do ocorrido">
                        </div> 
                        <div class="form-group col-md-12">
                            <label class="text-nowrap">Nome de usuário</label>
                            <input type="text" class="form-control CM" id="input_nome_usuario" placeholder="Digite seu nome de usuário">
                        </div> 
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Email</label>
                            <input type="email" class="form-control CM" id="input_email" placeholder="Digite seu CPF ou RG">
                        </div> 
                        <div class="form-group col-md-3">
                            <label class="text-nowrap">CPF/RG</label>
                            <input type="text" class="form-control CM" id="input_CPF_RG" placeholder="Digite seu CPF ou RG">
                        </div> 
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Senha</label>
                            <input type="password" class="form-control CM" id="input_senha" placeholder="Digite sua senha">
                        </div> 
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Confirmar senha</label>
                            <input type="password" class="form-control CM" id="input_confirm_senha" placeholder="Digite sua senha novamente">
                        </div> 
                    </div>
                    <div class="text-md-right text-center">
                        <button type="reset" class="btn CM cancel-CM shadow-none">Cancelar</button>
                        <button type="submit" class="btn CM save-CM shadow-none">Salvar</button>
                    </div>
                </form>
            </div> 
            <div class="container-fluid h-25"> </div>
        </div>
    </x-slot:container_form>
</x-layout>