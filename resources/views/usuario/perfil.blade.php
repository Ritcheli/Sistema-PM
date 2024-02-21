<x-layout>
    <x-slot:modal></x-slot:modal>

    <x-slot:title> Cadastro de usuários </x-slot:title>

    <x-slot:other_objects></x-slot:other_objects>

    <x-slot:container_form>
        <div class="container">
            <div class="mastercontainer-perfil">
                <div class="perfil-foto">
                    <div class="title-CM">
                        Perfil
                    </div>
                    <div class="container-perfil-foto">
                        <div class="foto-config">
                            <img class="foto" src="{{ URL::asset('/img/no-image-perfil.png') }}" alt="">
                        </div>
                        <div class="nome">
                            {{ $query_usuarios->nome_usuario }}
                        </div>
                    </div>
                </div>
                <div class="container-info-perfil">
                    <div class="title-CM mb-4">
                        Informações pessoais
                    </div>
                    <div class="container-data">
                        <div class="data">
                            <div class="title">
                                Nome completo
                            </div>
                            <div class="content">
                                {{ $query_usuarios->nome_completo }}
                            </div>
                        </div> 
                        <div class="data">
                            <div class="title">
                                Email
                            </div>
                            <div class="content">
                                {{ $query_usuarios->email }}
                            </div>
                        </div> 
                        <div class="data">
                            <div class="title">
                                CPF
                            </div>
                            <div class="content">
                                {{ $query_usuarios->CPF }}
                            </div>
                        </div> 
                        <div class="data">
                            <div class="title">
                                Data de nascimento
                            </div>
                            <div class="content">
                                {{ $query_usuarios->data_nascimento }}
                            </div>
                        </div> 
                        <div class="data">
                            <div class="title">
                                Status
                            </div>
                            <div class="content">
                                @if ($query_usuarios->status == 'A')
                                    Ativo
                                @else
                                    Inativo
                                @endif
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </x-slot:container_form>
</x-layout>