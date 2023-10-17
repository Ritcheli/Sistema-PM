<div class="modal fade" id="modal-pessoa" data-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header border-0 mb-0">
          <div class="modal-title title-CM mb-0 mx-2 mt-2" id="modal-pessoa-title"> </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-3">
            <form method="POST" action="{{ route('nova_Pessoa') }}" id="form-pessoas">
                @csrf
                <div class="form-row mb-3">
                    <label class="text-nowrap">Nome</label>
                    <input type="text" class="form-control CM" id="nome" name="nome" placeholder="Digite o nome da pessoa">
                    <span class="invalid-feedback" role="alert" id="nome-invalido"></span>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label class="text-nowrap">CPF/RG</label>
                        <input type="text" class="form-control CM mb-2" id="CPF_RG" name="CPF_RG" placeholder="Digite o CPF ou RG">
                        <span class="invalid-feedback" role="alert" id="CPF_RG-invalido"></span>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="text-nowrap">Telefone</label>
                        <input type="text" class="form-control CM" id="telefone" name="telefone" placeholder="Digite o telefone">
                        <span class="invalid-feedback" role="alert" id="telefone-invalido"></span>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="text-nowrap">Data de nascimento</label>
                        <input type="date" class="form-control CM" id="data_nascimento" name="data_nascimento">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label class="text-nowrap">Alcunha</label>
                        <input type="text" class="form-control CM mb-2" id="alcunha" name="alcunha" placeholder="Digite a alcunha">
                        <span class="invalid-feedback" role="alert" id="alcunha-invalido"></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label class="text-nowrap">Participação do envolvido por fato</label>
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="text-nowrap">Fato ocorrência</label>
                                        <div class="custom-selection envolvido-fato" id="envolvido_fato" hidden>
                                            <select name="native-select" id="vs_envolvido_fato" data-search="true" data-silent-initial-value-set="false">
                                                {{ $fatos_ocorrencias }}
                                            </select>
                                        </div>
                                        <span class="invalid-feedback" role="alert" id="envolvido_fato-invalido"></span>
                                    </div>
                                    <div class="form-group col">
                                        <label class="text-nowrap">Participação fato</label>
                                        <div class="custom-selection envolvido-participacao" id="envolvido_participacao" hidden>
                                            <select name="native-select" id="vs_envolvido_participacao" data-search="true" data-silent-initial-value-set="false">
                                                <option value="Apurar"> Apurar </option>
                                                <option value="Autor"> Autor </option>
                                                <option value="Comunicante"> Comunicante </option>
                                                <option value="Suspeito"> Suspeito </option>
                                                <option value="Testemunha"> Testemunha </option>
                                                <option value="Vítima"> Vítima </option>
                                            </select>
                                        </div>
                                        <span class="invalid-feedback" role="alert" id="envolvido_participacao-invalido"></span>
                                    </div>
                                    <div class="form-group col-auto mt-auto">
                                        <button type="submit" title="Inserir participação" id="inserir-parti" class="btn CM small add-CM shadow-none">
                                            <i class='bx bx-plus btn-icon-CM'></i>     
                                        </button>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <table class="table table-bordered CM mx-1 mb-3" id="table-fato-parti">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="w-50">Fato</th>
                                                <th scope="col" class="w-50">Participação</th>
                                                <th scope="col" class="w-20">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body-fato-parti">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="upload-img-component">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="text-nowrap">Fotos</label>
                            <div class="input-group CM" id="foto">
                                <label for="upload" class="label-foto pl-2 ml-1 pt-2 mt-1 text-muted"></label>
                                <input type="file" class="form-control input-foto" accept="image/png, image/jpg, image/jpeg" id="upload" name="upload" multiple>
                                <div class="input-group-append">    
                                    <label for="upload" class="btn btn-upl-CM m-1"> 
                                        <i class='bx bxs-cloud-upload btn-upl-icon-CM'></i>
                                        Escolha uma ou mais fotos
                                    </label>
                                </div>
                            </div>
                            <span class="invalid-feedback" role="alert" id="foto-invalido"></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <div class="rounded img-preview p-3"></div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label class="text-nowrap">Observações</label>
                        <div class="form-group mb-0">
                            <textarea class="CK_editor" id="observacao_pessoa" name='observacao_pessoa' placeholder="Digite a observação da pessoa"></textarea>
                            <span class="invalid-feedback" role="alert" id="observacao_pessoa-invalido"></span>
                        </div> 
                    </div>
                </div>
                <div class="text-md-right text-center mb-2 mt-1">
                    <button type="reset" data-dismiss="modal" class="btn CM large cancel-CM ml-1 mr-1 shadow-none">Cancelar</button>
                    <button type="submit" class="btn CM large save-CM ml-1 shadow-none" id="salvar-pessoa"></button>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>