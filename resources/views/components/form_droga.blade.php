<form id="form-drogas" class="form-tab">
    <div class="title-CM">Drogas</div>
    @csrf
    <div class="form-row">
        <div class="form-group col-md-12 mb-0">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="text-nowrap">Tipo</label>
                    <input type="text" class="form-control CM" id="tipo_droga" name="tipo_droga" maxlength="45" placeholder="Digite o tipo da droga">
                    <span class="invalid-feedback" role="alert" id="tipo_droga-invalido"></span>
                </div>
                <div class="form-group col-md-3">
                    <label class="text-nowrap">Quantidade</label>
                    <input type="text" class="form-control CM" id="qtd_droga" name="qtd_droga" placeholder="Digite a quantidade de droga">
                    <span class="invalid-feedback" role="alert" id="qtd_droga-invalida"></span>
                </div> 
                <div class="form-group col-md-3">
                    <label class="text-nowrap">Unidade de medida</label>
                    <input type="text" class="form-control CM" id="unidade_medida_droga" name="unidade_medida_droga" maxlength="30" placeholder="Digite unidade de medida">
                    <span class="invalid-feedback" role="alert" id="unidade_medida_droga-invalida"></span>
                </div> 
            </div>
            <div class="text-lg-right text-center mb-3">
                <button type="reset" class="btn CM medium cancel-CM ml-1 mr-1 shadow-none" id="reset_droga"> Limpar </button>
                <button type="submit" class="btn CM medium save-CM ml-2 shadow-none" id="salvar_droga" >
                    <i class='bx bxs-add-to-queue btn-icon-CM'></i>
                    Incluir
                </button>
            </div>
        </div> 
    </div>
</form>
<hr class="form-divisor">
<div class="title-CM">Adicionados</div> 
<table class="table table-bordered CM" id="table-droga">
    <thead>
        <tr>
            <th scope="col" class="w-50">Tipo</th>
            <th scope="col" class="w-15">Quantidade</th>
            <th scope="col" class="w-15">Un. medida</th>
            <th scope="col" class="w-10">Ações</th>
        </tr>
    </thead>
    <tbody id="table-body-droga">
        {{ $drogas }}
    </tbody>
</table>