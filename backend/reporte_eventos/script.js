

var $ = jQuery.noConflict ();

$(document).ready(function(){

	var datatable=$("#datatable");

	var bodyTable= datatable.find('tbody');

	var controller_url="backend/reporte_eventos/controller";

	//listar items
	getAll();

	function getAll(){
    	$.post(controller_url,{action:'list'}, function(retorno){
    		datatable.DataTable().destroy()
			
			bodyTable.html(retorno);

			
			datatable.DataTable({
		      "responsive": true,
		      "autoWidth": true,
		      "processing" : true,
		      pageLength: 10,
		    });


		})
   }

  
});