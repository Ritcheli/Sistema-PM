document.addEventListener("DOMContentLoaded", function(){
    $(".select-btn").on("click",function(){
        let custom_selection = $(this).parent();
        
        custom_selection.toggleClass("active");
    });

    $(".option").on("click", function(){
        let option                 = $(this).html();
        let select_btn             = $(this).parent().parent().siblings();
        let custom_selection       = $(this).parent().parent().parent();
        let active                 = select_btn.find(".active");
        let input_custom_selection = custom_selection.find(".input-custom-selection");
        
        input_custom_selection.val(option);
        active.html(option);
        custom_selection.toggleClass("active");
    });
}, false);

export function resetCustomSelection(){
    let custom_selection = $(".custom-selection");

    custom_selection.each(function(){
        let active                 = $(this).find('.active');
        let option_1               = $(this).find('.option')[0];
        let input_custom_selection = $(this).find(".input-custom-selection");

        active.html(option_1.innerText);
        input_custom_selection.val(option_1.innerText);
    });
}