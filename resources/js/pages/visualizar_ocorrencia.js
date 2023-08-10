import jsPDF from "jspdf";

document.addEventListener('DOMContentLoaded', function(){
    $('#pdfLALA').on('click', function(e){
        e.preventDefault();


        var doc = new jsPDF();
            
        // Source HTMLElement or a string containing HTML.
        var elementHTML = document.querySelector("#testee");

        doc.html(elementHTML, {
            margin: [15, 20, 15, 20],
            callback: function(doc) {
                // Save the PDF
                window.open(doc.output('bloburl'), '_blank');
            },
            // x: 20,
            // y: 15,
            width: 170, //target width in the PDF document
            windowWidth: 650 //window width in CSS pixels
        });

        // var doc = new jsPDF();
        // var img = new Image();

        // var src = "http://localhost:8000/img/logo-pm-sc.png";

        // img.src = src;

        // doc.addImage(img, 'PNG', 80, 15, 40, 40);
        // doc.text()
        
        // window.open(doc.output('bloburl'), '_blank');
    });
}, false);