var $ = jQuery.noConflict ();

$(document).ready(function(){



	var controller_url="backend/login/controller";


	//evento submit form login
	$('form[name="login"]').on('submit',function(e){
		e.preventDefault();
		var form=$(this);
		var formData=new FormData(this);
		formData.append('action','login')

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
				//console.log(res);	
				response=JSON.parse(res);


				if(response.status){
					getMessage('success',response.message);
					window.location.href='./index';

				}else{
					getMessage('danger', response.message);					
					
				}
			}

		})
		return false;


	})

   function getMessage(type,message){
   	 var text='<div class="alert alert-sm alert-'+type+'" style="padding:4px">'+message+'</div>';

   	 $('.retorno').html(text);

   	 setTimeout(function(){
   	 	$('.retorno').html('');
   	 },4000)
   }
});