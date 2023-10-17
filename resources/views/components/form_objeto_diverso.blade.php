<form id="form-objetos-diversos" class="form-tab">
    <div class="title-CM">Objetos diversos</div> 
    @csrf
    <div class="form-row">
        <div class="form-group col-md-12 mb-0">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="text-nowrap">Número de identificação</label>
                    <input type="text" class="form-control CM" id="num_identificacao" name="num_identificacao" maxlength="45" placeholder="Digite o número de identificação">
                    <span class="invalid-feedback" role="alert" id="num_identificacao-invalido"></span>
                </div>
                <div class="form-group col-md-6">
                    <label class="text-nowrap">Tipo objeto</label>
                    <div class="custom-selection tipo-obj" id="tipo_obj" hidden>
                        <select name="native-select" id="vs_tipo_objeto" data-search="true" data-silent-initial-value-set="false">
                            {{ $tipos_objetos }}
                        </select>
                    </div>
                    <span class="invalid-feedback" role="alert" id="tipo_objeto-invalido"></span>
                </div> 
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label class="text-nowrap">Marca</label>
                    <input type="text" class="form-control CM" id="marca_objeto" name="marca_objeto" maxlength="60" placeholder="Digite a marca do objeto">
                    <span class="invalid-feedback" role="alert" id="marca_objeto-invalida"></span>
                </div> 
                <div class="form-group col-md-4">
                    <label class="text-nowrap">Modelo</label>
                    <input type="text" class="form-control CM" id="modelo_objeto" name="modelo_objeto" maxlength="45" placeholder="Digite o modelo do objeto">
                    <span class="invalid-feedback" role="alert" id="modelo_objeto-invalido"></span>
                </div>
                <div class="form-group col-md-2">
                    <label class="text-nowrap">Un de medida</label>
                    <input type="text" class="form-control CM" id="unidade_medida_obj" name="unidade_medida_obj" maxlength="30" placeholder="Digite a unidade de medida do objeto">
                    <span class="invalid-feedback" role="alert" id="unidade_medida_obj-invalida"></span>
                </div>
                <div class="form-group col-md-2">
                    <label class="text-nowrap">Quantidade</label>
                    <input type="text" class="form-control CM" id="quantidade_objeto" name="quantidade_objeto" placeholder="Digite a Quantidade">
                    <span class="invalid-feedback" role="alert" id="quantidade_objeto-invalida"></span>
                </div>
            </div>
            <div class="text-lg-right text-center mb-3">
                <button type="reset" class="btn CM medium cancel-CM ml-1 mr-1 shadow-none" id="reset_obj"> Limpar </button>
                <button type="submit" class="btn CM medium save-CM ml-2 shadow-none" id="salvar_obj_diverso" >
                    <i class='bx bxs-add-to-queue btn-icon-CM'></i>
                    Incluir
                </button>
            </div>
        </div> 
    </div>
</form>
<hr class="form-divisor">
<div class="title-CM">Adicionados</div> 
<table class="table table-bordered CM" id="table-objeto">
    <thead>
        <tr>
            <th scope="col" class="w-20">Tipo</th>
            <th scope="col" class="w-30">Marca</th>
            <th scope="col" class="w-25">Modelo</th>
            <th scope="col" class="w-5">Quantidade</th>
            <th scope="col" class="w-10">Ações</th>
        </tr>
    </thead>
    <tbody id="table-body-objeto">
        {{ $objetos_diversos }}
    </tbody>
</table>