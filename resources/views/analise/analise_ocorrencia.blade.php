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
                    <form action="{{ route('plot_SNA_Graph') }}" method="POST" id="plot_SNA_Graph">
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
            <div class="container-fluid CM plot-SNA-graph mb-6"> 
                <nav class="navbar SNA-graph navbar-expand-sm">
                    <img class="navbar-brand img-nav-brand" src="{{ URL::asset('/img/logo-pm-sc.png') }}" alt="">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>  

                    <div class="collapse navbar-collapse disabled" id="navbar_SNA">
                        <ul class="navbar-nav mr-auto" id="SNA_menu">
                            <li class="nav-item dropdown">
                                <div class="nav-link SNA-graph" data-toggle="dropdown" aria-expanded="false">
                                    Opções
                                </div>
                                <div class="dropdown-menu">
                                    <div class="dropdown-item SNA-graph check-dropdown-menu pl-2 align-items-center" id="check_menu_nome_nodo">
                                        <span class="dropdown-item-check dropdown-item-check-start-inactive hidden"> 
                                            <i class='bx bx-check'></i>
                                        </span>
                                        <span class="dropdown-item-label">
                                            Nomes dos nodos
                                        </span>
                                    </div>
                                    <div class="dropdown-item SNA-graph check-dropdown-menu pl-2 align-items-center" id="check_menu_legenda">
                                        <span class="dropdown-item-check dropdown-item-check-start-active"> 
                                            <i class='bx bx-check'></i>
                                        </span>
                                        <span class="dropdown-item-label">
                                            Legendas
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <div class="nav-link SNA-graph" data-toggle="dropdown" aria-expanded="false">
                                    Métricas
                                </div>
                                <div class="dropdown-menu">
                                    <label for="DCN_radio" id='DCN_radio_tutorial' class="m-0" style="width: 100%">
                                        <div class="dropdown-item">
                                            <div class="custom-control-sm custom-radio SNA-graph ml-3">
                                                <input type="radio" id="DCN_radio" name="custom_radio" class="custom-control-input" @checked(true)>
                                                <label class="custom-control-label" for="DCN_radio">Centralidade de grau</label>
                                            </div>
                                        </div>
                                    </label>
                                    <label for="BCN_radio" class="m-0" style="width: 100%">
                                        <div class="dropdown-item">
                                            <div class="custom-control-sm custom-radio SNA-graph ml-3">
                                                <input type="radio" id="BCN_radio" name="custom_radio" class="custom-control-input">
                                                <label class="custom-control-label" for="BCN_radio">Centralidade de intermediação</label>
                                            </div>
                                        </div>
                                    </label>
                                    <label for="CCN_radio" class="m-0" style="width: 100%">
                                        <div class="dropdown-item">
                                            <div class="custom-control-sm custom-radio SNA-graph ml-3">
                                                <input type="radio" id="CCN_radio" name="custom_radio" class="custom-control-input">
                                                <label class="custom-control-label" for="CCN_radio">Centralidade de proximidade</label>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-item SNA-graph check-dropdown-menu pl-2 align-items-center" id="check_detect_community">
                                        <span class="dropdown-item-check dropdown-item-check-start-inactive hidden"> 
                                            <i class='bx bx-check'></i>
                                        </span>
                                        <span class="dropdown-item-label">
                                            Detectar comunidades
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <div class="nav-link SNA-graph" data-toggle="dropdown" aria-expanded="false">
                                    Exportar
                                </div>
                                <div class="dropdown-menu">
                                    <div class="dropdown-item SNA-graph check-dropdown-menu pl-2 align-items-center">
                                        <span class="dropdown-item-label ml-2">
                                            PDF
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <div class="nav-link SNA-graph" data-toggle="dropdown" aria-expanded="false">
                                    Ajuda
                                </div>
                            </li>
                        </ul>
                        <form class="form-menu-search-SNA" id="menu_search_in_graph">
                            <div class="custom-selection search-in-graph" id="vs_search_in_graph"></div>
                            <button class="btn btn-outline-success btn-search-menu-SNA" type="submit">
                                <i class='bx bx-search btn-icon-CM'></i>
                                Procurar
                            </button>
                        </form>
                    </div>
                </nav>
                <div class="fit-zoom mt-4 ml-4" id="fit_zoom" hidden>
                    <i class='bx bx-fullscreen'></i>
                </div>
                <div class="container-fluid CM info-nodo mb-0 mt-4" id="legendas" hidden>
                    <div class="container">
                        <div class="row pb-3 info-nodo-title">
                            <strong> Legenda </strong>
                        </div>
                        <div class="info-nodo-content"></div>
                    </div>
                </div>
                <div class="container-fluid CM info-tutorial ml-4">
                    TEST
                </div>
                <div id="cy" style="min-height: 600px" value="{{ URL::asset('') }}" class="d-flex align-items-center justify-content-center"> 
                </div>
            </div>
        </div>
    </x-slot:container_form>

</x-layout>