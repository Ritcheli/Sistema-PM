<div class="modal fade" id="modal-busca-veiculos" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header border-0 mb-0">
          <div class="modal-title title-CM mb-0" id="exampleModalLabel"> Buscar veiculos </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <table id="table-busca-veiculo" class="table table-bordered CM mb-3">
                    <thead>
                        <tr>
                            <th scope="col">Placa</th>
                            <th scope="col" class="w-20">Marca/Modelo</th>
                            <th scope="col">Cor</th>
                            <th scope="col">Renavam</th>
                        </tr>
                    </thead>
                    <tbody id="table-body-busca-veiculo">
                    </tbody>
                </table>
            </div>
            <div class="pagination-container d-flex justify-content-center" id="pagination-busca-veiculo"></div>
        </div>
      </div>
    </div>
</div>