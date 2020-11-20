var $ = jQuery.noConflict ();

$(document).ready(function(){

	var datatable=$("#datatable");

	var bodyTable= datatable.find('tbody');

	var controller_url="backend/grupo/controller";

	//listar items
	getAll();

	//evento click adicionar
	$('#btnAdd').click(function(){
		var modal=$('#modalAdd');
		var body= modal.find('.modal-body');

		$.post(controller_url,{action:'addForm'},function(response){
			body.html(response);
			modal.modal({backdrop:false});
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
				console.log(res);
				response= JSON.parse(res);

				if(response.status){
					getMessage('success','Grupo Registado');
					getAll();
				}else{
					getMessage('danger','Erro ao registar');
				}
			}

		})
		return false;
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
				button.attr('disabled',false);
				response= JSON.parse(res);

				if(response.status){
					getMessage('success','Grupo Editado');
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
			message:'Pretende apagar o perfil selecionado?',
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



	//evento de click adicionar utilizador ao grupo
	bodyTable.on('click','#btn-addutilizador',function(){
		var id_grupo=$(this).attr('data-id');
		var modal=$('#modalAdd');
		var body=modal.find('.modal-body');

		$.post(controller_url,{action:'userForm',id_grupo:id_grupo},function(response){
			body.html(response);
			modal.modal();
			listUser(id_grupo);

			//evento de click eliminar
			$('#modalAdd').find('tbody').on('click','#btn-delete-user', function(){
				var id_utilizador=$(this).attr('data-id');
				bootbox.confirm({
					size:'small',
					message:'Pretende remover o utilizador?',
					callback: function(result){
						if(result==true)
						{
							$.post(controller_url,{action:'deleteUser',id_utilizador:id_utilizador,id_grupo:id_grupo},function(res){

								response = JSON.parse(res);

								if(response.status)
								{
									listUser(id_grupo);
								}
							})
						}
					}
				});
			})
		})
	})



	/****
	*	Gerir utilizador nos grupos
	*
	***/

	$('#modalAdd').on('click','#btnAdd',function(){
		var id_grupo=$(this).attr('data-id')
		var modal=$('#modalUser');
		var body= modal.find('.modal-body');

		$.post(controller_url,{action:'addUserForm', id_grupo:id_grupo},function(response){
			body.html(response);
			modal.modal({backdrop:false});
		})
	})


	//evento submit form register
	$('#modalUser').on('submit','form[name="registerUser"]',function(){
		var id_grupo=$('#modalAdd').find('#btnAdd').attr('data-id')
		var form=$(this);
		var button=form.find(':button');
		$.ajax({
			url:controller_url,
			type:'POST',
			data: 'action=registerUser&'+form.serialize(),
			beforeSend: function(){
				button.attr('disabled',true);
			},
			success: function(res){
				button.attr('disabled',false);
				console.log(res);
				response= JSON.parse(res);

				if(response.status){
					getMessage('success','Utilizador Adicionado');
					listUser(id_grupo);
					formAddUser()
				}else{
					getMessage('danger','Erro ao adicionar');
				}
			}

		})
		return false;
	})

	



	function formAddUser(){
		var id_grupo=$('#modalAdd').find('#btnAdd').attr('data-id')
		var modal=$('#modalUser');
		var body= modal.find('.modal-body');

		$.post(controller_url,{action:'addUserForm', id_grupo:id_grupo},function(response){
			body.html(response);
		})
	}

	
	

    function getAll(){
    	$.post(controller_url,{action:'list'}, function(retorno){
    		datatable.DataTable().destroy()
			$estado= 1;

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


	function listUser(id_grupo){
		let table=$('#modalAdd').find('#tableUser')

		let body= table.find('tbody');

		$.post(controller_url,{action:'listUser',id_grupo:id_grupo}, function(retorno){
			table.DataTable().destroy()
	/*		var data=JSON.parse(retorno);
			var text="";
			data.forEach(function(item){
				text+='<tr>';
				text+='<td><img style="max-height:30px;boder-radius:50%" src="data:image/png;base64,'+item.foto+'"></td>';
				text+='<td>'+item.nome+'</td>';
				text+='<td>'+item.departamento+'</td>';
				text+='<td>';
				text+='<button id="btn-delete-user" data-id="'+item.id+'" class="btn btn-sm btn-action btn-danger"><i class="fa fa-trash"></i></button>';
				text+='</td>';
				text+='</tr>';
				*/
				

			body.html(retorno);

			
			table.DataTable({
		      "responsive": true,
		      "autoWidth": false,
		      "processing" : true,
		      pageLength: 10,
		    });
		})
		
		
	}

});