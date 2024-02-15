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
                        {{ $total_drugs_current_month }}
                    </div>
                    <div class="un_medida">
                        Kg
                    </div>
                </div>
                <div class="top-footer">
                    <div class="top-footer-arrow">
                        <i class='bx bx-up-arrow-alt bx-fade-down' ></i>
                    </div>
                    Aumento de {{ $drugs_balance }}
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
                        10
                    </div>
                    <div class="un_medida">
                        Pes
                    </div>
                </div>
                <div class="top-footer">
                    <div class="top-footer-arrow">
                        <i class='bx bx-up-arrow-alt bx-fade-down' ></i>
                    </div>
                    Aumento de 10%
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
                        5
                    </div>
                    <div class="un_medida">
                        Un
                    </div>
                </div>
                <div class="top-footer">
                    <div class="top-footer-arrow">
                        <i class='bx bx-up-arrow-alt bx-fade-down' ></i>
                    </div>
                    Aumento de 10%
                </div>
                <div class="footer">
                    * Comparação ao último mês
                </div>
            </div> 
        </div>
        
    </x-slot:container_form>
</x-layout>