<div>
    <div class="modal fade" id="modal-veiculo" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header border-0 mb-0">
              <div class="modal-title title-CM mb-0 mx-2 mt-2" id="modal-veiculo-title"> Veículos </div>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body mx-3">
                <form id="form-veiculos">
                    @csrf
                    <div class="form-row mb-3">
                        <label class="text-nowrap">Placa</label>
                        <input type="text" class="form-control CM" id="placa" name="placa" placeholder="Digite a placa do veículo">
                        <span class="invalid-feedback" role="alert" id="placa-invalida"></span>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Marca/Modelo</label>
                            <input type="text" class="form-control CM mb-2" id="marca_modelo_veiculo" name="marca_modelo_veiculo" placeholder="Digite a marca ou modelo">
                            <span class="invalid-feedback" role="alert" id="marca_modelo_veiculo-invalido"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Cor</label>
                            <input type="text" class="form-control CM" id="cor_veiculo" name="cor_veiculo" placeholder="Digite a cor do veículo">
                            <span class="invalid-feedback" role="alert" id="cor_veiculo-invalida"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Chassi</label>
                            <input type="text" class="form-control CM" id="chassi" name="chassi" placeholder="Digite o código do chassi">
                            <span class="invalid-feedback" role="alert" id="chassi-invalido"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Renavam</label>
                            <input type="text" class="form-control CM mb-2" id="renavam" name="renavam" placeholder="Digite a Renavam">
                            <span class="invalid-feedback" role="alert" id="renavam-invalido"></span>
                        </div>
                        <div class="form-group col-md">
                            <label class="text-nowrap">Participação</label>
                            <input type="text" class="form-control CM mb-2" id="participacao_veiculo" name="participacao_veiculo" placeholder="Digite o a participação do veículo na ocorrência">
                            <span class="invalid-feedback" role="alert" id="participacao_veiculo-invalida"></span>
                        </div>
                    </div> 
                    <div class="text-md-right text-center mb-2 mt-1">
                        <button type="reset" data-dismiss="modal" class="btn CM large cancel-CM ml-1 mr-1 shadow-none">Cancelar</button>
                        <button type="submit" class="btn CM large save-CM ml-1 shadow-none" id="salvar-veiculo"> Salvar </button>
                    </div>
                </form>
            </div>
          </div>
        </div>
    </div>
</div>