<form id="form-animais" class="form-tab">
    <div class="title-CM">Animais</div> 
    @csrf
    <div class="form-row">
        <div class="form-group col-md-12 mb-0">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label class="text-nowrap">Espécie</label>
                    <input type="text" class="form-control CM" id="especie_animal" name="especie_animal" maxlength="45" placeholder="Digite a espécie do animal">
                    <span class="invalid-feedback" role="alert" id="especie_animal-invalida"></span>
                </div>
                <div class="form-group col-md-3">
                    <label class="text-nowrap">Quantidade</label>
                    <input type="text" class="form-control CM" id="qtd_animal" name="qtd_animal" placeholder="Digite a quantidade">
                    <span class="invalid-feedback" role="alert" id="qtd_animal-invalida"></span>
                </div> 
                <div class="form-group col-md-6">
                    <label class="text-nowrap">Participação</label>
                    <input type="text" class="form-control CM" id="participacao_animal" name="participacao_animal" maxlength="30" placeholder="Digite participação do animal">
                    <span class="invalid-feedback" role="alert" id="participacao_animal-invalida"></span>
                </div> 
            </div>
            <div class="form-row">
                <div class="form-group col-md">
                    <label class="text-nowrap">Outras informações</label>
                    <input type="text" class="form-control CM" id="outras_info_animal" name="outras_info_animal" maxlength="45" placeholder="Digite outras informações sobre o animal">
                    <span class="invalid-feedback" role="alert" id="outras_info_animal-invalida"></span>
                </div>
            </div>
            <div class="text-lg-right text-center mb-3">
                <button type="reset" class="btn CM medium cancel-CM ml-1 mr-1 shadow-none" id="reset_animal"> Limpar </button>
                <button type="submit" class="btn CM medium save-CM ml-2 shadow-none" id="salvar_animal" >
                    <i class='bx bxs-add-to-queue btn-icon-CM'></i>
                    Incluir
                </button>
            </div>
        </div> 
    </div>
</form>
<hr class="form-divisor">
<div class="title-CM">Adicionados</div> 
<table class="table table-bordered CM" id="table-animal">
    <thead>
        <tr>
            <th scope="col" class="w-15">Espécie</th>
            <th scope="col" class="w-15">Quantidade</th>
            <th scope="col" class="w-50">Participação</th>
            <th scope="col" class="w-10">Ações</th>
        </tr>
    </thead>
    <tbody id="table-body-animal">
        {{ $animais }}
    </tbody>
</table>