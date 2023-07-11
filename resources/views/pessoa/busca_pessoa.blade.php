<x-layout>
    <x-slot:modal></x-slot:modal>

    <x-slot:title> Busca de pessoas </x-slot:title>

    <x-slot:container_form>
        <div class="container-fluid px-0">
            <div class="container-fluid CM mb-4">
                <form method="GET" action="">
                    <div class="title-CM">Filtros</div>
                    <div class="form-row"> 
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Nome</label>
                            <input type="text" class="form-control CM" id="input_nome" name="input_nome" value="{{ $nome }}" placeholder="Nome da pessoa">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-nowrap">Alcunha</label>
                            <input type="text" class="form-control CM" id="input_alcunha" name="input_alcunha" value="{{ $alcunha }}" placeholder="Alcunha">
                        </div>
                    </div>
                    <div class="text-lg-right text-center mb-3">
                        <button type="reset" id="limpar_filtros" class="btn CM medium cancel-CM ml-1 mr-1 shadow-none"> Limpar </button>
                        <button type="submit" class="btn CM medium save-CM ml-2 shadow-none" id="buscar_ocorr" >
                            <i class='bx bx-search btn-icon-CM'></i>  
                            Buscar
                        </button>
                    </div>
                </form>
            </div>
            <div class="container-fluid CM mb-6">
                <div class="form-row">
                    <table class="table table-bordered CM mx-1 mb-3" id="table-pessoa">
                        <thead>
                            <tr>
                                <th scope="col" class="w-5">ID</th>
                                <th scope="col" class="w-20">Nome</th>
                                <th scope="col" class="w-20">Alcunha</th>
                                <th scope="col" class="w-10">RG/CPF</th>
                                <th scope="col" class="w-10">Data Nasc</th>
                                <th scope="col" class="w-10">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="table-body-ocorrrencia">
                            @foreach ($pessoas as $pessoa)
                                <tr class="envolvido">
                                    <th scope="row" class="align-middle">
                                        {{ $pessoa->id_pessoa }}
                                    </th>
                                    <td class="align-middle">
                                        {{ $pessoa->nome }}
                                    </td>
                                    <td class="align-middle">
                                        {{ $pessoa->alcunha }}
                                    </td>
                                    <td class="align-middle">
                                        {{ $pessoa->RG_CPF }}
                                    </td>
                                    <td class="align-middle">
                                        {{ $pessoa->data_nascimento }}
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex justify-content-between">
                                            <a type="button" value="" title="Visualizar" class="btn btn-table-view w-30" href={{ route('show_Visualizar_Pessoa', ['id_pessoa' => $pessoa->id_pessoa]) }}> 
                                                <i class='bx bx-show btn-table-icon-CM'></i>
                                            </a>
                                            <a type="button" value="" title="Editar" class="btn btn-table-edit w-30" href={{ route('show_Editar_Pessoa', ['id_pessoa' => $pessoa->id_pessoa]) }}> 
                                                <i class='bx bxs-edit btn-table-icon-CM'></i>
                                            </a>
                                            <a type="button" value="{{ $pessoa->id_pessoa }}" title="Remover" class="btn btn-table-remove btn-remove-pessoa w-30"> 
                                                <i class='bx bxs-trash btn-table-icon-CM'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {!! $pessoas->onEachSide(1)->links() !!}
                </div>
            </div>
        </div>
    </x-slot:container_form>
</x-layout>