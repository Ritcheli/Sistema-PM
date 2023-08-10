<x-layout>
    <x-slot:modal> </x-slot:modal>

    <x-slot:title> Dashboard </x-slot:title>

    <x-slot:other_objects></x-slot:other_objects>

    <x-slot:container_form>
        <div class="container-fluid px-0">
            <div class="row">
                <div class="col-md-3">
                    <div class="container-fluid DT">
                        <div class="row">
                            <div class="col-md-12">
                                Drogas apreendidas
                                <hr class="line-separator">
                            </div>
                            <div class="col-md-6 d-flex align-self-end">
                                <div class="col-md pl-0 text-number">
                                    20
                                </div>
                                <div class="col-md pl-0 un-medida d-flex align-self-end">
                                    Kg
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-center mt-3">
                                <img height="75" width="75" src="http://localhost:8000/uploads/icons/drug.png" alt="">
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="col-md-3">
                    <div class="container-fluid DT">
                        <div class="row">
                            <div class="col-md-12">
                                Ocorrencias registradas
                                <hr class="line-separator">
                            </div>
                            <div class="col-md-6 d-flex align-self-end">
                                <div class="col-md pl-0 text-number">
                                    100
                                </div>
                                <div class="col-md pl-0 un-medida d-flex align-self-end">
                                    Un
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-center mt-3">
                                <img height="75" width="75" src="http://localhost:8000/uploads/icons/ocorr.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="container-fluid DT">
                        <div class="row">
                            <div class="col-md-12">
                                Armas apreendidas
                                <hr class="line-separator">
                            </div>
                            <div class="col-md-6 d-flex align-self-end">
                                <div class="col-md pl-0 text-number">
                                    15
                                </div>
                                <div class="col-md pl-0 un-medida d-flex align-self-end">
                                    Un
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-center mt-3">
                                <img height="75" width="75" src="http://localhost:8000/uploads/icons/weapon.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="container-fluid DT">
                        <div class="row">
                            <div class="col-md-12">
                                Pessoas apreendidas
                                <hr class="line-separator">
                            </div>
                            <div class="col-md-6 d-flex align-self-end">
                                <div class="col-md pl-0 text-number">
                                    5
                                </div>
                                <div class="col-md pl-0 un-medida d-flex align-self-end">
                                    Pes
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-center mt-3">
                                <img height="75" width="75" src="http://localhost:8000/uploads/icons/Person.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-4 mb-6">
                    <div class="container-fluid DT">
                        <canvas id="chart" class="w-100" height="365px"></canvas>
                    </div>
                </div>
                <div class="col-md-6 mt-4 mb-6">
                    <div class="container-fluid DT">
                        <canvas id="chart2" class="w-100" height="365px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:container_form>
</x-layout>