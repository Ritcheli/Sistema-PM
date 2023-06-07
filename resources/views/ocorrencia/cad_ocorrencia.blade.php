<x-layout>
    <x-slot:modal>
        <x-modal-busca-pessoas></x-modal-busca-pessoas>
        <x-modal-pessoa></x-modal-pessoa>
    </x-slot:modal>

    <x-slot:title> Cadastro de ocorrências </x-slot:title>
    
    <x-slot:user> Ritcheli </x-slot:user>

    <x-slot:container_form>
        <div class="container-fluid px-0">
            <div class="container-fluid CM mb-5">
                <form method="POST" action=" {{ route('buscar_Pessoa_Ocorr_Modal') }} " id="form-envolvidos">
                    <div class="title-CM">Envolvidos</div> 
                    <div class="form-row">
                        <div class="form-group col-md-12 mb-0">
                            <label class="text-nowrap">Buscar</label>
                            <div class="form-row">
                                <div class="form-group col">
                                    <input type="text" class="form-control CM" id="input-buscar" placeholder="Digite o nome do envolvido">
                                </div> 
                                <div class="form-group col-auto">
                                    <button type="submit" title="Buscar" id="search-pessoa" class="btn CM medium search-CM shadow-none">
                                        <i class='bx bx-search btn-icon-CM'> </i>
                                    </button>
                                </div>
                                <div class="form-group col-auto">
                                    <button type="reset" title="Cadastrar novo" id="cad-pessoa" class="btn CM medium add-CM shadow-none">
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
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                    </div>
                </form>
            </div> 
            <div class="container-fluid CM mb-6">
                <form>
                    <div class="title-CM">Nova ocorrência</div> 
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label class="text-nowrap">Número do protocolo</label>
                            <input type="text" class="form-control CM" id="input_num_protocolo" placeholder="Número de protocolo">
                        </div> 
                        <div class="form-group col-md-4">
                            <label class="text-nowrap">Data do ocorrido</label>
                            <input type="date" class="form-control CM" id="input_data_ocorrencia" placeholder="Data do ocorrido">
                        </div> 
                        <div class="form-group col-md-12">
                            <label class="text-nowrap">Nome de usuário</label>
                            <input type="text" class="form-control CM" id="input_nome_usuario" placeholder="Nome de usuário">
                        </div> 
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Email</label>
                            <input type="email" class="form-control CM" id="input_email" placeholder="Email">
                        </div> 
                        <div class="form-group col-md-3">
                            <label class="text-nowrap">CPF/RG</label>
                            <input type="text" class="form-control CM" id="input_CPF_RG" placeholder="CPF ou RG">
                        </div> 
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Senha</label>
                            <input type="password" class="form-control CM" id="input_senha" placeholder="Senha">
                        </div> 
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Confirmar senha</label>
                            <input type="password" class="form-control CM" id="input_confirm_senha" placeholder="Digite sua senha novamente">
                        </div> 
                        <div class="form-group col">
                            <label class="text-nowrap">Observações</label>
                            <div class="form-group mb-0">
                                <textarea class="CK_editor" id="descricao_ocor" placeholder="Digite a descrição da ocorrência"> </textarea>
                            </div> 
                        </div>
                    </div>
                    <div class="text-lg-right text-center mb-2">
                        <button type="reset" id="cancelar-cad-ocorrencia" class="btn CM large cancel-CM ml-1 mr-1 shadow-none">Cancelar</button>
                        <button type="submit" class="btn CM large save-CM ml-1 shadow-none">Salvar</button>
                    </div>
                </form>
            </div>  
        </div>
    </x-slot:container_form>
</x-layout>

