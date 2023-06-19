<x-layout>
    <x-slot:modal></x-slot:modal>

    <x-slot:title> Consulta de ocorrências </x-slot:title>

    <x-slot:container_form>
        <div class="container-fluid px-0">
            <div class="container-fluid CM mb-5">
                <div class="title-CM">Consulta de ocorrências</div> 
                <div class="form-row">
                    <table class="table table-bordered CM mx-1 mb-3" id="table-pessoa">
                        <thead>
                            <tr>
                                <th scope="col" class="w-10">Num Protocolo</th>
                                <th scope="col" class="w-40">Nome</th>
                                <th scope="col" class="w-30">CPF ou RG</th>
                                <th scope="col" class="w-10">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="table-body-pessoa">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-slot:container_form>
</x-layout>