

var $ = jQuery.noConflict ();

$(document).ready(function(){

	var datatable=$("#datatable");

	var bodyTable= datatable.find('tbody');

	var controller_url="backend/utilizador/controller";

	//listar items
	getAll();

	//evento click adicionar
	$('#btnAdd').click(function(){
		var modal=$('#modalAdd');
		var body= modal.find('.modal-body');

		$.post(controller_url,{action:'addForm'},function(response){
			body.html(response);
			modal.modal();
		})
		
	})


	//mudar foto
	$('#modalAdd').on('change','#foto',function(){
		  var countFiles = $(this)[0].files.length;
		  var imgPath = $(this)[0].value;
		  var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
		  var foto_holder = $("#foto_holder");
		  foto_holder.empty();
		    if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
		        if (typeof(FileReader) != "undefined") {
		          for (var i = 0; i < countFiles; i++) 
		            {
		              var reader = new FileReader();
		              reader.onload = function(e) {
		              	foto_holder.attr('src',e.target.result);
		              }
		              reader.readAsDataURL($(this)[0].files[i]);
		            }
		        }
		      }

	})

	//evento submit form register
	$('#modalAdd').on('submit','form[name="register"]',function(e){
		e.preventDefault();
		var form=$(this);
		var foto=$("#foto").prop("files")[0];
		var formData=new FormData(this);
		formData.append('foto_file',foto)
		formData.append('action','register')

		var button=form.find(':button');
		$.ajax({
			url:controller_url,
			type:'POST',
			data: formData,
			enctype:'multipart/form-data',
			processData:false,
			contentType: false,
			beforeSend: function(){
				button.attr('disabled',true);
			},
			success: function(res){
				button.attr('disabled',false);
				response= JSON.parse(res);

				if(response.status){
					getMessage('success','Perfil Utilizador Registado');
					getAll();
				}else{
					getMessage('danger','Erro registro perfil utilizador');
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
	$('#modalAdd').on('submit','form[name="edit"]',function(e){
		e.preventDefault();
		var form=$(this);
		var foto=$("#foto").prop("files")[0];
		var formData=new FormData(this);
		formData.append('foto_file',foto)
		formData.append('action','edit')
		var button=form.find(':button');
		$.ajax({
			url:controller_url,
			type:'POST',
			data: formData,
			enctype:'multipart/form-data',
			processData:false,
			contentType: false,
			beforeSend: function(){
				button.attr('disabled',true);
			},
			success: function(res){
				button.attr('disabled',false);
				response= JSON.parse(res);

				if(response.status){
					getMessage('success','Perfil Utilizador Editado');
					getAll();
				}else{
					getMessage('danger','Erro edição perfil utilizador');
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

		////evento de desbloquear utilizador
		bodyTable.on('click','#btn-desbloquear', function(){
			var id=$(this).attr('data-id');
			bootbox.confirm({
				size:'small',
				message:'Pretende Desbloquear utilizador selecionado?',
				callback: function(result){
					if(result==true)
					{
						$.post(controller_url,{action:'desbloquear',id:id},function(res){
	
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

		////evento de desbloquear utilizador
		bodyTable.on('click','#btn-bloquear', function(){
			var id=$(this).attr('data-id');
			bootbox.confirm({
				size:'small',
				message:'Pretende bloquear utilizador selecionado?',
				callback: function(result){
					if(result==true)
					{
						$.post(controller_url,{action:'bloquear',id:id},function(res){
	
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
		var body= modal.find('.modal-body');

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
				//console.log(res)
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
			var data= JSON.parse(retorno);
			var text="";
			data.forEach(function(item){
				text+='<tr>';
				text+='<td><img style="max-height:30px;boder-radius:50%" src="data:image/png;base64,'+item.foto+'"></td>';
				text+='<td>'+item.nome+'</td>';
				text+='<td>'+item.numero_funcionario+'</td>';
				text+='<td>'+item.departamento+'</td>';
				text+='<td>'+item.funcao+'</td>';
				text+='<td>'+item.email+'</td>';
				text+='<td>'+item.telefone+'</td>';
				text+='<td>';
				text+='<button id="btn-edit" data-id="'+item.id+'" class="btn btn-sm btn-action btn-warning"><i class="fa fa-edit"></i></button>';
				text+='<button id="btn-delete" data-id="'+item.id+'" class="btn btn-sm btn-action btn-danger"><i class="fa fa-trash"></i></utton>';
				if(item.estado==1){
					text+='<button id="btn-bloquear" data-id="'+item.id+'" class="btn btn-sm btn-action btn-info"><i class="fa fa-lock"></i></utton>';
				}else{
					text+='<button id="btn-desbloquear" data-id="'+item.id+'" class="btn btn-sm btn-action btn-info"><i class="fa fa-lock-open"></i></utton>';
				}
				
				text+='</td>';
				text+='</tr>';
				})

			bodyTable.html(text);

			
			datatable.DataTable({
		      "responsive": true,
		      "autoWidth": true,
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

});