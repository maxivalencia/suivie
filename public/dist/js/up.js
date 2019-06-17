$(document).ready(function(){
    function notification(){
        // mise en place d'ajax pour récupérer le nombre de message recue
        let routage = $('#notif_non').val()
        //let routage = 'http://127.0.0.1:8000/notif_non';
        $.get(routage, function(data){
            // Une ou plusieurs instructions
            $('#non').text(data['dataResponse']);
            //alert(data['dataResponse']);
        });
    
        // mise à jout affichage
        
    }
	setInterval(notification, 10000);
    //var routing = "{{ path('upload_file') }}";
    //var routing = "127.0.0.1:8000/upload_file";
    var routing = $('#upload_file').val();
	$("#fileuploader").uploadFile({
	    url:routing,
        fileName:"myfile",
        //formData:{refpiecejointe: $('#piecejointes').val()}
	});
});