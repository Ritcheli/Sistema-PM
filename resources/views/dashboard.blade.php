<x-layout>
    <x-slot:modal> </x-slot:modal>

    <x-slot:title> Dashboard </x-slot:title>

    <x-slot:other_objects></x-slot:other_objects>

    <x-slot:container_form>
        <div class="mastercontainer-dashboard">
            <div class="container-card-data">
                <div class="head">
                    <div class="title">
                        Drogas apreendidas
                    </div>
                    <div class="img">
                        <img class="card-data-icon" src="{{ URL::asset('/uploads/icons/Drugs.png') }}" alt="">
                    </div>
                </div>
                <div class="body">
                    <div class="value">
                        {{ $drugs_balance[2] }}
                    </div>
                    <div class="un_medida">
                        Kg
                    </div>
                </div>
                <div class="top-footer @if ($drugs_balance[1] == 'Aumento') inc @else dec @endif">
                    <div class="top-footer-arrow">
                        @if ($drugs_balance[1] == "Aumento")
                            <i class='bx bx-up-arrow-alt bx-fade-down' ></i>
                        @else
                            <i class='bx bx-down-arrow-alt bx-fade-down' ></i>
                        @endif
                    </div>
                    @if ($drugs_balance[1] == "Aumento")
                        Aumento de {{ $drugs_balance[0] }}
                    @else
                        Diminuição de {{ $drugs_balance[0] }}
                    @endif
                </div>
                <div class="footer">
                    * Comparação ao último mês
                </div>
            </div>
            <div class="container-card-data">
                <div class="head">
                    <div class="title">
                        Pessoas apreendidas
                    </div>
                    <div class="img">
                        <img style="width: 6vw; height: 11vh;" class="card-data-icon" src="{{ URL::asset('/uploads/icons/People.png') }}" alt="">
                    </div>
                </div>
                <div class="body">
                    <div class="value">
                        {{ $pessoas_balance[2] }}
                    </div>
                    <div class="un_medida">
                        Pes
                    </div>
                </div>
                <div class="top-footer @if ($pessoas_balance[1] == 'Aumento') inc @else dec @endif">
                    <div class="top-footer-arrow">
                        @if ($pessoas_balance[1] == "Aumento")
                            <i class='bx bx-up-arrow-alt bx-fade-down' ></i>
                        @else
                            <i class='bx bx-down-arrow-alt bx-fade-down' ></i>
                        @endif
                    </div>
                    @if ($pessoas_balance[1] == "Aumento")
                        Aumento de {{ $pessoas_balance[0] }}
                    @else
                        Diminuição de {{ $pessoas_balance[0] }}
                    @endif
                </div>
                <div class="footer">
                    * Comparação ao último mês
                </div>
            </div>
            <div class="container-card-data">
                <div class="head">
                    <div class="title">
                        Armas apreendidas
                    </div>
                    <div class="img">
                        <img class="card-data-icon" src="{{ URL::asset('/uploads/icons/Weapon.png') }}" alt="">
                    </div>
                </div>
                <div class="body">
                    <div class="value">
                        {{ $armas_balance[2] }}
                    </div>
                    <div class="un_medida">
                        Un
                    </div>
                </div>
                <div class="top-footer @if ($armas_balance[1] == 'Aumento') inc @else dec @endif">
                    <div class="top-footer-arrow">
                        @if ($armas_balance[1] == "Aumento")
                            <i class='bx bx-up-arrow-alt bx-fade-down' ></i>
                        @else
                            <i class='bx bx-down-arrow-alt bx-fade-down' ></i>
                        @endif
                    </div>
                    @if ($armas_balance[1] == "Aumento")
                        Aumento de {{ $armas_balance[0] }}
                    @else
                        Diminuição de {{ $armas_balance[0] }}
                    @endif
                </div>
                <div class="footer">
                    * Comparação ao último mês
                </div>
            </div> 
        </div>
        
    </x-slot:container_form>
</x-layout>