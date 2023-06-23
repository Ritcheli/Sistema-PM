document.addEventListener('DOMContentLoaded', function () {
    if ($('.input-daterange').length > 0){
        $('.initial-date').on('change', function(){
            let input_initial_date = $(this);
            let input_final_date   = $(this).siblings('.final-date');

            if (input_final_date.val() != ""){
                if (input_initial_date.val() > input_final_date.val()){
                    input_initial_date.val(input_final_date.val());
                }
            }

            input_final_date.attr('min', $(this).val());
        }); 

        $('.final-date').on('change', function(){
            let input_final_date   = $(this);
            let input_initial_date = $(this).siblings('.initial-date');

            if (input_initial_date.val() != ""){
                if (input_final_date.val() < input_initial_date.val()){
                    input_final_date.val(input_initial_date.val());
                }
            }

            input_initial_date.attr('max', $(this).val());
        });
    }
}, false);