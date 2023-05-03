<x-layout>
    <x-slot:modal>
        <div class="modal fade" id="standart-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header border-0 mb-0">
                  <div class="modal-title title-CM mb-0" id="exampleModalLabel"> Pessoas </div>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <table class="table table-bordered CM mb-3">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Last</th>
                                    <th scope="col">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                  </tr>
                                  <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                  </tr>
                                  <tr>
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>@twitter</td>
                                  </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </x-slot:modal>

    <x-slot:title> Cadastro de ocorrências </x-slot:title>
    
    <x-slot:user> Ritcheli </x-slot:user>

    <x-slot:container_form>
        <div class="container-fluid px-0">
            <div class="container-fluid CM mb-5">
                <form>
                    <div class="title-CM">Envolvidos</div> 
                    <div class="form-row">
                        <div class="form-group col-md-12 mb-0">
                            <label class="text-nowrap">Buscar</label>
                            <div class="form-row">
                                <div class="form-group col">
                                    <input type="text" class="form-control CM" id="input_buscar" placeholder="Digite o nome do envolvido">
                                </div> 
                                <div class="form-group col-auto d-none d-block d-md-none">
                                    <button type="reset" class="btn CM medium search-CM shadow-none" data-toggle="modal" data-target="#standart-modal">
                                        <i class='bx bx-search'> </i>
                                    </button>
                                </div>
                                <div class="form-group col-auto d-none d-md-block" data-toggle="modal" data-target="#standart-modal">
                                    <button type="reset" class="btn CM medium search-CM shadow-none pl-4 pr-4">
                                        Buscar
                                    </button>
                                </div>
                            </div>

                            <div class="form-row">
                                <table class="table table-bordered CM mx-1 mb-3 ">
                                    <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Last</th>
                                            <th scope="col">Handle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td>@mdo</td>
                                          </tr>
                                          <tr>
                                            <th scope="row">2</th>
                                            <td>Jacob</td>
                                            <td>Thornton</td>
                                            <td>@fat</td>
                                          </tr>
                                          <tr>
                                            <th scope="row">3</th>
                                            <td>Larry</td>
                                            <td>the Bird</td>
                                            <td>@twitter</td>
                                          </tr>
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
                    <div class="text-lg-right text-center mb-2">
                        <button type="reset" class="btn CM large cancel-CM ml-1 mr-1  shadow-none">Cancelar</button>
                        <button type="submit" class="btn CM large save-CM ml-1 mr-1 shadow-none">Salvar</button>
                    </div>
                </form>
            </div>  
        </div>
    </x-slot:container_form>
</x-layout>

