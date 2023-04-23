const body    = document.querySelector("body"),
      sidebar = body.querySelector(".sidebar-CM"),
      toggle  = body.querySelector(".toggle-CM"),
      search  = body.querySelector(".search-box-CM"),
      links   = body.querySelectorAll(".links-CM"),
      sub_menu = body.querySelectorAll(".sub-menu-CM"),
      arrow_link = body.querySelectorAll(".arrow-link-CM");

      toggle.addEventListener("click", ()=>{
        sidebar.classList.toggle("close-CM");
        
        for (var i = 0; i < links.length; i++){
          links[i].classList.remove("open-CM");
          sub_menu[i].classList.add("close-CM");
        }
      });

      for (var i = 0; i < arrow_link.length; i++){
        arrow_link[i].addEventListener("click", (e)=>{
          let links = e.target.parentElement.parentElement;
          let sub_menu =  e.target.parentElement.parentElement.lastElementChild;

          links.classList.toggle("open-CM");
          sub_menu.classList.toggle("close-CM");
        });
      }

      search.addEventListener("click", ()=>{
        sidebar.classList.remove("close-CM");
      });