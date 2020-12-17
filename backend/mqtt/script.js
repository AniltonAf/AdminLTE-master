

var $ = jQuery.noConflict();

$(document).ready(function () {




	var controller_url = "backend/mqtt/controller";


	var btnClick;



	getAll();

	//evento submit form register
	$('form[name="mqttForm"]').on('submit', function () {

		var form = $(this);
		var button = form.find(':button');

		if (btnClick === 'btnGravar') {
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
		} else if (btnClick === 'btnTestSocket') {
			$('button').attr('disabled', true)
			let server = $('input[name="server_mqtt"]').val();
			let port = $('input[name="port_ws"]').val()
			let id_cliente = $('input[name="id_cliente"]').val()
			let username = $('input[name="username"]').val()
			let password = $('input[name="password"]').val()


			client = new Paho.MQTT.Client(server, Number(port), id_cliente);
			client.onConnectionLost = onConnectionLost;
			client.onMessageArrived = onMessageArrived;

			client.connect({ timeout: 1, onSuccess: onConnect, onFailure: onFailure, userName: username, password: password });


			// called when the client connects
			function onConnect() {
				// Once a connection has been made, make a subscription and send a message.
				client.disconnect()
				getMessage('success', 'Conexão estabelecida com o websocket');
				$('button').attr('disabled', false)
			}

			function onFailure() {
				getMessage('danger', 'Conexão estabelecida com o websocket');
				$('button').attr('disabled', false)
			}

			// called when the client loses its connection
			function onConnectionLost(responseObject) {
				if (responseObject.errorCode !== 0) {
					console.log("onConnectionLost:" + responseObject.errorMessage);
				}
			}

			// called when a message arrives
			function onMessageArrived(message) {
				console.log("onMessageArrived:" + message.payloadString);
			}
		}

		else if (btnClick === 'btnTestMqtt') {
			$('button').attr('disabled', true)
			let server = $('input[name="server_mqtt"]').val();
			let port = $('input[name="port_mqtt"]').val()
			let id_cliente = $('input[name="id_cliente"]').val()
			let username = $('input[name="username"]').val()
			let password = $('input[name="password"]').val()


			$.post(
				controller_url,
				{
					action: 'teste_mqtt',
					server: server,
					port: port,
					id_cliente: id_cliente,
					username: username,
					password: password
				},
				function (retorno) {
					$('button').attr('disabled', false)
					let res=JSON.parse(retorno);

					if(res.status){
						getMessage('success', res.message);
					}else{
						getMessage('danger', res.message);
					}
				}
			)
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
		$.post(controller_url, { action: 'form', test: 777 }, function (retorno) {
			$('form[name="mqttForm"]').html(retorno);

			$('button[type=submit]').click(function () {
				btnClick = $(this).attr('id')
			})
		})
	}


});