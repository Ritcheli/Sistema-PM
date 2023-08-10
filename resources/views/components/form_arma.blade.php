<div class="container-fluid CM mt-4">
    <form id="form-armas">
        @csrf
        <div class="title-CM">Armas</div> 
        <div class="form-row">
            <div class="form-group col-md-12 mb-0">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-nowrap">Tipo</label>
                        <input type="text" class="form-control CM" id="tipo_arma" name="tipo_arma" maxlength="45" placeholder="Digite o tipo da arma">
                        <span class="invalid-feedback" role="alert" id="tipo_arma-invalido"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-nowrap">Espécie</label>
                        <input type="text" class="form-control CM" id="especie_arma" name="especie_arma" maxlength="45" placeholder="Digite a espécie da arma">
                        <span class="invalid-feedback" role="alert" id="especie_arma-invalida"></span>
                    </div> 
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label class="text-nowrap">Fabricação</label>
                        <input type="text" class="form-control CM" id="fabricacao_arma" name="fabricacao_arma" maxlength="45" placeholder="Digite a fabricação da arma">
                        <span class="invalid-feedback" role="alert" id="fabricacao_arma-invalida"></span>
                    </div> 
                    <div class="form-group col-md-4">
                        <label class="text-nowrap">Calibre</label>
                        <input type="text" class="form-control CM" id="calibre_arma" name="calibre_arma" maxlength="45" placeholder="Digite o calibre da arma">
                        <span class="invalid-feedback" role="alert" id="calibre_arma-invalido"></span>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="text-nowrap">Número de série</label>
                        <input type="text" class="form-control CM" id="num_serie_arma" name="num_serie_arma" maxlength="45" placeholder="Digite o número de série">
                        <span class="invalid-feedback" role="alert" id="num_serie_arma-invalido"></span>
                    </div>
                </div>
                <div class="text-lg-right text-center mb-3">
                    <button type="reset" class="btn CM medium cancel-CM ml-1 mr-1 shadow-none" id="reset_arma"> Limpar </button>
                    <button type="submit" class="btn CM medium save-CM ml-2 shadow-none" id="salvar_arma" >
                        <i class='bx bxs-add-to-queue btn-icon-CM'></i>
                        Incluir
                    </button>
                </div>
            </div> 
        </div>
    </form>
</div>
<div class="container-fluid CM mt-4">
    <table class="table table-bordered CM" id="table-arma">
        <thead>
            <tr>
                <th scope="col" class="w-30">Tipo</th>
                <th scope="col" class="w-20">Espécie</th>
                <th scope="col" class="w-25">Fabricação</th>
                <th scope="col" class="w-5">Calibre</th>
                <th scope="col" class="w-10">Ações</th>
            </tr>
        </thead>
        <tbody id="table-body-arma">
            {{ $armas }}
        </tbody>
    </table>
</div>