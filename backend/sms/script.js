

var $ = jQuery.noConflict();

$(document).ready(function () {

	let controller_url = "backend/sms/controller";

	let modalTest=$('#modalTeste');

	let corpoTest=modalTest.find('.modal-body');


	getAll();

	var btnClick;

	//evento submit form register
	$('form[name="smsForm"]').on('submit', function () {
	
		var form = $(this);
		var button = form.find(':button');

		if(btnClick==='btnGravar'){
			$.ajax({
				url: controller_url,
				type: 'POST',
				data: 'action=update&' + form.serialize(),
				beforeSend: function () {
					button.attr('disabled', true);
				},
				success: function (res) {
					button.attr('disabled', false);
					response = JSON.parse(res);

					if (response.status) {
						getMessage('success', 'Configuração de sms atualizadas');
						getAll();
					} else {
						getMessage('danger', 'Erro ao configurar');
						}
					}

			})
			return false;
		}

		else if(btnClick==='btnTest'){

			$.post(controller_url,{action:'formTeste'},function(response){
				corpoTest.html(response);
				modalTest.modal({backdrop:false})
			})
		}
		return false;

	})

	modalTest.on('submit','form[name=teste]', function(){
		let form=$(this);
		let data= form.serializeArray();


		let users=[
			{
				nome: "Teste SMS",
				numero: data[0].value,
			}
		]

		let mensagem= data[1].value;

		$.post('./backend/servico',{action:'send_sms',users: JSON.stringify(users),mensagem:mensagem},function(response){
			response=JSON.parse(response);

			let status= response.status? 'success':'danger';

			getMessageSMS(status,response.message);
		})

		return false;
	})

/*

			$('form[name="testeForm"]').on('submit', function () {
				
				var form = $(this);
				var button = form.find(':button');
				
				$.post(controller_url,{action:'test_sms'},function(res){
					console.log(res);
					//response = JSON.parse(res);
					//if (response.status) {
					if (res) {
							getMessage('success', 'Teste E-mail realizado com sucesso');
							
					} else {
							getMessage('danger', 'Erro teste envio de E-mail');
					}
				})


				return false;
			})

*/

	function getMessage(type, message) {
		var text = '<div class="alert alert-sm alert-' + type + '" style="padding:4px">' + message + '</div>';

		$('.retorno').html(text);

		setTimeout(function () {
			$('.retorno').html('');
		}, 4000)
	}

	function getMessageSMS(type, message) {
		var text = '<div class="alert alert-sm alert-' + type + '" style="padding:4px">' + message + '</div>';

		$('.retornoSms').html(text);

		setTimeout(function () {
			$('.retornoSms').html('');
		}, 4000)
	}

	function getAll() {
		$.post(controller_url, { action: 'form' }, function (retorno) {
			$('form[name="smsForm"]').html(retorno)

			$('button[type=submit]').click(function () {
				btnClick = $(this).attr('id')
			})
		})
	}


});