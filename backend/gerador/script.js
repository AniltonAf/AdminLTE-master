var $ = jQuery.noConflict ();

$(document).ready(function(){

	var datatable=$("#datatable");

	var bodyTable= datatable.find('tbody');

	var controller_url="backend/gerador/controller";

	//listar items
	getAll();

	//evento click adicionar
	$('#btnAdd').click(function(){
		var modal=$('#modalAdd');
		var body= modal.find('.modal-body');

		$.post(controller_url,{action:'addForm'},function(response){
			body.html(response);
			getPosionGerador();
			modal.modal();
		})
		
	})

	//evento submit form register
	$('#modalAdd').on('submit','form[name="register"]',function(){
		var form=$(this);
		var button=form.find(':button');
		$.ajax({
			url:controller_url,
			type:'POST',
			data: 'action=register&'+form.serialize(),
			beforeSend: function(){
				button.attr('disabled',true);
			},
			success: function(res){
				button.attr('disabled',false);
				response= JSON.parse(res);

				if(response.status){
					getMessage('success','Gerador registado');
					getAll();
				}else{
					getMessage('danger','Erro ao registar');
				}
			}

		})
		return false;
	})

	//evento de click detalhes gerador
	bodyTable.on('click','#btn-detail',function(){
		var id=$(this).attr('data-id');
		var modal=$('#modalAdd');
		var body= modal.find('.modal-body');

		$.post(controller_url,{action:'detailForm',id:id},function(response){
			body.html(response);
			modal.modal();
		})

	})

	//evento de click editar
	bodyTable.on('click','#btn-config',function(){
		var id=$(this).attr('data-id');
		var modal=$('#modalAdd');
		var body= modal.find('.modal-body');

		$.post(controller_url,{action:'configPage',id:id},function(response){
			body.html(response);
			modal.modal();
			getPosionGerador();
			
		})
	})

	//evento de click editar
	bodyTable.on('click','#btn-edit',function(){
		var id=$(this).attr('data-id');
		var modal=$('#modalAdd');
		var body= modal.find('.modal-body');

		$.post(controller_url,{action:'editForm',id:id},function(response){
			body.html(response);
			modal.modal();
		})
	})
	//evento submit form edit
	$('#modalAdd').on('submit','form[name="edit"]',function(){
		var form=$(this);
		var button=form.find(':button');
		$.ajax({
			url:controller_url,
			type:'POST',
			data: 'action=edit&'+form.serialize(),
			beforeSend: function(){
				button.attr('disabled',true);
			},
			success: function(res){
				console.log(res)
				button.attr('disabled',false);
				response= JSON.parse(res);

				if(response.status){
					getMessage('success','Gerador Editado');
					getAll();
				}else{
					getMessage('danger','Erro ao editar');
				}
			}

		})
		return false;
	})

	//evento de click eliminar
	bodyTable.on('click','#btn-delete', function(){
		var id=$(this).attr('data-id');
		bootbox.confirm({
			size:'small',
			message:'Pretende apagar o gerador?',
			callback: function(result){
				if(result==true)
				{
					$.post(controller_url,{action:'delete',id:id},function(res){

						response = JSON.parse(res);

						if(response.status)
						{
							getAll();
						}
					})
				}
			}
		});
	})



	//evento de click editar
	bodyTable.on('click','#btn-permissao',function(){
		var id=$(this).attr('data-id');
		var modal=$('#modalAdd');
		var body=modal.find('.modal-body');

		$.post(controller_url,{action:'permitionForm',id:id},function(response){
			body.html(response);
			modal.modal();
		})
	})

	//evento submit form permition
	$('#modalAdd').on('submit','form[name="permition"]',function(){
		var form=$(this);

		var data=form.serializeArray()

		var id_perfil=form.attr('id-perfil');

		var response={perfil:id_perfil,permissao:data};

		var button=form.find(':button');

		$.ajax({
			url:controller_url,
			type:'POST',
			data: 'action=permissao&data='+JSON.stringify(response),
			beforeSend: function(){
				button.attr('disabled',true);
			},
			success: function(res){
				button.attr('disabled',false);
				response= JSON.parse(res);


				if(response.status){
					getMessage('success','Permissões atualizadas');
					getAll();
				}else{
					getMessage('danger','Erro ao atualizar');
				}
			}

		})
		return false;
	})

	
	

    function getAll(){
    	$.post(controller_url,{action:'list'}, function(retorno){
    		datatable.DataTable().destroy()
	/*		var data=JSON.parse(retorno);
			$estado= 1;
			var text="";
			data.forEach(function(item){
				text+='<tr>';
				text+='<td>'+item.foto+'</td>';
				text+='<td>'+item.modelo+'</td>';				
				text+='<td>'+item.fabricante+'</td>';
				text+='<td>'+item.descricao+'</td>';
				//text+='<td>'+item.potencia+'</td>';
				//text+='<td>'+item.hora_trabalho+'</td>';
				//text+='<td>'+item.ip+'</td>';
				//text+='<td>'+item.data_manutencao+'</td>';
				text+='<td>'+item.nome+'</td>';
				text+='<td>';
				text+='<button id="btn-detail" data-id="'+item.id+'" class="btn btn-sm btn-action btn-info"><i class="fa fa-info"></i></button>';
				text+='<button id="btn-edit" data-id="'+item.id+'" class="btn btn-sm btn-action btn-warning"><i class="fa fa-edit"></i></button>';
				text+='<button id="btn-delete" data-id="'+item.id+'" class="btn btn-sm btn-action btn-danger"><i class="fa fa-trash"></i></button>';
				text+='</td>';
				text+='</tr>';
				})*/

			bodyTable.html(retorno);

			
			datatable.DataTable({
		      "responsive": true,
		      "autoWidth": false,
		      "processing" : true,
		      pageLength: 10,
		    });


		})
   }

   function getMessage(type,message){
   	 var text='<div class="alert alert-sm alert-'+type+'" style="padding:4px">'+message+'</div>';

   	 $('.retorno').html(text);

   	 setTimeout(function(){
   	 	$('.retorno').html('');
   	 },4000)
   }

   function getFormData($form){
	    var unindexed_array = $form.serializeArray();
	    var indexed_array = {};

	    $.map(unindexed_array, function(n, i){
	        indexed_array[n['name']] = n['value'];
	    });

	    return indexed_array;
	}

	function getPosionGerador(){
			
			// https://account.mapbox.com
			mapboxgl.accessToken = 'pk.eyJ1IjoiaXZhbmlsZG9lZSIsImEiOiJja2hmYWwxcWkwYWptMnhwYzk2c3lmNWJxIn0.MG7-GSqPrk3JCepjLMSB9Q';
			var map = new mapboxgl.Map({
				container: 'map',
				style: 'mapbox://styles/mapbox/streets-v8',
				center: [-24.24721217421829, 15.905888745235975],
				zoom: 7
			});

			
			map.on('click', function (e) {
				$('input[name=latitude]').val(e.lngLat.lat);
				$('input[name=longitude]').val(e.lngLat.lng);
			});
		//}
	
	}

});