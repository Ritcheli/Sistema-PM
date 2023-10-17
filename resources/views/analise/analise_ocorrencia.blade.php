<x-layout>
    <x-slot:modal></x-slot:modal>

    <x-slot:title> Análise Ocorrências </x-slot:title>

    <x-slot:other_objects></x-slot:other_objects>

    <x-slot:container_form>
        <div class="container-fluid px-0">
            <div class="container-fluid CM mb-4">
                <div class="d-flex justify-content-between"> 
                    <div class="title-CM">Configuração da rede</div>

                    <a data-toggle="collapse" href="#colapse_rede_config" aria-controls="collapseExample">
                        <i class="bx bx-menu collapse-button"></i>
                    </a> 
                </div>
                <div class="collapse show" id="colapse_rede_config">
                    <form action="{{ route('plot_SNA_Ocorrencia_Pessoa') }}" method="POST" id="plot_SNA_pessoa_ocorrencia">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="text-nowrap">Tipo da rede</label>
                                <div class="custom-selection rede-tipo" id="vs_rede_tipo"></div>
                                <span class="invalid-feedback" role="alert" id="vs_rede_tipo-invalida"></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="text-nowrap">Participação dos envolvidos</label>
                                <div class="custom-selection rede-participacao" id="vs_rede_participacao" multiple></div>
                                <span class="invalid-feedback" role="alert" id="vs_rede_participacao-invalida"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-nowrap">Grupo das ocorrências</label>
                                <div class="custom-selection grupo-ocorr" id="vs_grupo_ocorr" disabled></div>
                                <span class="invalid-feedback" role="alert" id="vs_grupo_ocorr-invalido"></span>
                            </div>
                        </div>
                        <div class="text-lg-right text-center mb-3">
                            <button type="submit" class="btn CM medium save-CM ml-2 shadow-none">
                                <i class='bx bxs-add-to-queue btn-icon-CM'></i>
                                Plotar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="container-fluid CM mb-6"> 
                <div class="container-fluid CM info-nodo mb-0" id="legendas" hidden>
                    <div class="container">
                        <div class="row pb-3">
                            <strong> Legenda </strong>
                        </div>
                        <div class="subtitle-content">
                        </div>
                    </div>
                </div>
                <div id="cy" style="min-height: 600px" value="{{ URL::asset('') }}"> </div>
            </div>
        </div>
    </x-slot:container_form>

</x-layout>