<nav class="sidebar-CM">
    <header>
        <div class="image-text-CM">
            <span class="image-CM">
                <img src="{{ URL::asset('/img/logo-pm-sc.png') }}" alt="">
            </span>

            <div class="sidebar-text-CM header-text-CM">
                <span class="name-CM"> Polícia Militar - SC</span>
                <span class="user-CM"> {{ Auth::user()->nome_usuario }} </span>
            </div>
        </div>

        <i class='bx bx-chevron-left toggle-CM'></i>
    </header>
    <div class="menu-bar-CM">
        <div class="top-content-CM">
            <li class="search-box-CM">
                <a href="#"> 
                    <i class='bx bx-search-alt-2 icon-CM'></i>
                    <input type="sidebar-text-CM" placeholder="Procurar...">
                </a>
            </li>
            <div class="menu-CM">
                <ul class="menu-links-CM">
                    <li class="nav-link-CM">
                        <a href={{ route("show_Dashboard") }}> 
                            <i class='bx bxs-home icon-CM'></i>
                            <span class="sidebar-text-CM"> Dashboard </span>
                        </a>
                    </li>
                    <div class="links-CM">
                        <li class="icon-link-CM">
                            <a href="#"> 
                                <i class='bx bxs-notepad icon-CM'></i>
                                <span class="sidebar-text-CM"> Ocorrências </span>
                            </a>
                            <i class='bx bx-chevron-down arrow-link-CM'></i>
                        </li>
                        <ul class="sub-menu-CM close-CM"> 
                            <li> <a href="{{ route("show_Cad_Ocorrencia") }}"> Cadastro</a> </li>
                            <li> <a href="{{ route("show_Busca_Ocorrencia") }}"> Consulta </a> </li>
                            <li> <a href="#"> Suboption3 </a> </li>
                        </ul>
                    </div>
                    <div class="links-CM">
                        <li class="icon-link-CM">
                            <a href="#"> 
                                <i class='bx bxl-graphql icon-CM'></i>
                                <span class="sidebar-text-CM"> Option2 </span>
                            </a>
                            <i class='bx bx-chevron-down arrow-link-CM'></i>
                        </li>
                        <ul class="sub-menu-CM close-CM">
                            <li> <a href="#"> Suboption1 </a> </li>
                            <li> <a href="#"> Suboption2 </a> </li>
                            <li> <a href="#"> Suboption3 </a> </li>
                        </ul>
                    </div>
                    <div class="links-CM">
                        <li class="icon-link-CM">
                            <a href="#"> 
                                <i class='bx bxl-graphql icon-CM'></i>
                                <span class="sidebar-text-CM"> Option2 </span>
                            </a>
                            <i class='bx bx-chevron-down arrow-link-CM'></i>
                        </li>
                        <ul class="sub-menu-CM close-CM">
                            <li> <a href="#"> Suboption1 </a> </li>
                            <li> <a href="#"> Suboption2 </a> </li>
                            <li> <a href="#"> Suboption3 </a> </li>
                        </ul>
                    </div>
                    <div class="links-CM">
                        <li class="icon-link-CM">
                            <a href="#"> 
                                <i class='bx bxl-graphql icon-CM'></i>
                                <span class="sidebar-text-CM"> Option2 </span>
                            </a>
                            <i class='bx bx-chevron-down arrow-link-CM'></i>
                        </li>
                        <ul class="sub-menu-CM close-CM">
                            <li> <a href="#"> Suboption1 </a> </li>
                            <li> <a href="#"> Suboption2 </a> </li>
                            <li> <a href="#"> Suboption3 </a> </li>
                        </ul>
                    </div>
                    <li class="nav-link-CM">
                        <a href="#"> 
                            <i class='bx bxs-home icon-CM'></i>
                            <span class="sidebar-text-CM"> Option1 </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="">
            <li class="bottom-content-CM">
                <a href={{ route("logout") }}> 
                    <i class='bx bx-log-out icon-CM'></i>
                    <span class="sidebar-text-CM"> Logout </span>
                </a>
            </li>
        </div>
    </div>
</nav>