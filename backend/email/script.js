

var $ = jQuery.noConflict();

$(document).ready(function () {

	var controller_url = "backend/email/controller";



	getAll();


	var btnClick;


	//evento submit form register
	$('form[name="emailForm"]').on('submit', function () {

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
					console.log(res)
					button.attr('disabled', false);
					response = JSON.parse(res);
	
					if (response.status) {
						getMessage('success', 'Configuração de email atualizadas');
						getAll();
					} else {
						getMessage('danger', 'Erro ao configurar');
					}
				}
				
			})
			return false;
		}

		else if(btnClick==='btnTest'){
			$.ajax({
				url: 'backend/servico',
				type: 'POST',
				data: 'action=test_email&' + form.serialize(),
				beforeSend: function () {
					button.attr('disabled', true);
				},
				success: function (res) {
					button.attr('disabled', false);
					response = JSON.parse(res);
	
					if (response.status) {
						getMessage('success', response.message);
					} else {
						getMessage('danger', response.message);
					}
				}
	
			})
		}

		return false;
	})



	function getMessage(type, message) {
		var text = '<div class="alert alert-sm alert-' + type + '" style="padding:4px">' + message + '</div>';

		$('.retorno').html(text);

		setTimeout(function () {
			$('.retorno').html('');
		}, 4000)
	}

	function getAll() {
		$.post(controller_url, { action: 'form' }, function (retorno) {
			$('form[name="emailForm"]').html(retorno)

			$('button[type=submit]').click(function () {
				btnClick = $(this).attr('id')
			})
		})
	}

});