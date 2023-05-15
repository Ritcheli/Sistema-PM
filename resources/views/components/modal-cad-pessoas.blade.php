<div class="modal fade" id="modal-cad-pessoas" data-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header border-0 mb-0">
          <div class="modal-title title-CM mb-0 mx-2 mt-2" id="exampleModalLabel"> Cadastrar pessoas </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-3">
            <form action="">
                @csrf
                <div class="form-row mb-3">
                    <label class="text-nowrap">Nome</label>
                    <input type="text" class="form-control CM" id="input_nome" placeholder="Digite o nome da pessoa">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label class="text-nowrap">CPF/RG</label>
                        <input type="text" class="form-control CM mb-2" id="input_CPF-RG" placeholder="Digite o CPF ou RG">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="text-nowrap">Telefone</label>
                        <input type="text" class="form-control CM" id="input_telefone" placeholder="Digite o telefone">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="text-nowrap">Data de nascimento</label>
                        <input type="date" class="form-control CM" id="input_data_nasc">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label class="text-nowrap">Alcunha</label>
                        <input type="text" class="form-control CM mb-2" id="input_alcunha" placeholder="Digite a alcunha">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label class="text-nowrap">Fotos</label>
                        <div class="input-group">
                            <label id="label-upl" for="upload" class="pl-2 ml-1 pt-2 mt-1 text-muted"></label>
                            <input id="upload" type="file" class="form-control" accept="image/png, image/jpg, image/jpeg" multiple>
                            <div class="input-group-append">    
                                <label for="upload" class="btn btn-upl-CM m-1"> 
                                    <i class='bx bxs-cloud-upload btn-upl-icon-CM'></i>
                                    Escolha uma ou mais fotos
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <div class="rounded img-preview p-3"> </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label class="text-nowrap">Observações</label>
                        <div class="form-group mb-0">
                            <textarea class="CK_editor" id="observacao_pessoa" name='observacao_pessoa' placeholder="Digite a observação da pessoa"></textarea>
                        </div> 
                    </div>
                </div>
                <div class="text-md-right text-center mb-2 mt-1">
                    <button type="reset" data-dismiss="modal" class="btn CM large cancel-CM ml-1 mr-1 shadow-none">Cancelar</button>
                    <button type="submit" class="btn CM large save-CM ml-1 shadow-none">Salvar</button>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>