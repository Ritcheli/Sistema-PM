<x-layout>
    <x-slot:modal></x-slot:modal>

    <x-slot:title> Análise Ocorrências </x-slot:title>

    <x-slot:other_objects></x-slot:other_objects>

    <x-slot:container_form>
        <div class="container-fluid px-0">
            <div class="container-fluid CM mb-4">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-Ocorr-Pess-tab" data-toggle="tab" data-target="#nav-Ocorr-Pess" type="button" role="tab" aria-controls="nav-Ocorr-Pess" aria-selected="true">Ocorrências - Pessoas</button>
                        <button class="nav-link" id="nav-Fato-Pess-tab" data-toggle="tab" data-target="#nav-Fato-Pess" type="button" role="tab" aria-controls="nav-Fato-Pess" aria-selected="false">Fatos - Pessoas</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-Ocorr-Pess" role="tabpanel" aria-labelledby="nav-Ocorr-Pess-tab">
                        <form action="{{ route('plot_SNA_Ocorrencia_Pessoa') }}" method="POST" id="plot_SNA_pessoa_ocorrencia" class="pt-4">
                            <div class="text-lg-right text-center mb-3">
                                <button type="submit" class="btn CM medium save-CM ml-2 shadow-none">
                                    <i class='bx bxs-add-to-queue btn-icon-CM'></i>
                                    Plotar
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade show" id="nav-Fato-Pess" role="tabpanel" aria-labelledby="nav-Fato-Pess-tab">
                        <form action="{{ route('plot_SNA_Pessoa_Fato_Ocorrencia') }}" method="POST" id="plot_SNA_fato_pessoa" class="pt-4">
                            <div class="text-lg-right text-center mb-3">
                                <button type="submit" class="btn CM medium save-CM ml-2 shadow-none">
                                    <i class='bx bxs-add-to-queue btn-icon-CM'></i>
                                    Plotar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container-fluid CM mb-5">
                <div style="min-height: 400px"> 
                    <div class="container-fluid CM info-nodo mb-0" id="legendas" hidden>
                        <div class="container">
                            <div class="row pb-3">
                                <strong> Legenda </strong>
                            </div>
                            <div class="subtitle-content">
                            </div>
                        </div>
                    </div>
                    <div id="component" value= "{{ URL::asset('') }}"> </div>
                </div>
            </div>
        </div>
    </x-slot:container_form>

</x-layout>