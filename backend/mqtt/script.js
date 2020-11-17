

var $ = jQuery.noConflict();

$(document).ready(function () {

	var controller_url = "backend/mqtt/controller.php";



	getAll();

	//evento submit form register
	$('form[name="mqttForm"]').on('submit', function () {
	
		var form = $(this);
		var button = form.find(':button');
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
					getMessage('success', 'Configurações do servidor MQTT foram atualizados');
					getAll();
				} else {
					getMessage('danger', 'Erro ao atualizar');
				}
			}

		})
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
			$('form[name="mqttForm"]').html(retorno);
		})
	}


});