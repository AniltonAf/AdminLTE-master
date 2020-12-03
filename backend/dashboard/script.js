var $ = jQuery.noConflict();

$(document).ready(function () {

	var datatable = $("#datatable");

	var bodyTable = datatable.find('tbody');

	var controller_url = "backend/dashboard/controller";

	//listar items
	getAll();

	getMap();



	$('#modalAdd').on('click', '#btnAdd', function () {
		var id_grupo = $(this).attr('data-id')
		var modal = $('#modalUser');
		var body = modal.find('.modal-body');

		$.post(controller_url, { action: 'addUserForm', id_grupo: id_grupo }, function (response) {
			body.html(response);
			modal.modal({ backdrop: false });
		})
	})


	function getAll() {
		$.post(controller_url, { action: 'count_estado' }, function (retorno) {
			response = JSON.parse(retorno);
			console.log(response)
			$('.gerador_on').html(response.gerador_status.on)
			$('.gerador_off').html(response.gerador_status.off)
			$('.gerador_avariado').html(response.gerador_avariado.on)
			$('.rede_publica_on').html(response.rede_publica.on)
			$('.rede_publica_off').html(response.rede_publica.off)
			$('.qua_aut_trans_on').html(response.qua_aut_trans.on)
			$('.qua_aut_trans_off').html(response.qua_aut_trans.off)
			$('.low_fuel_on').html(response.low_fuel.on)
			$('.low_fuel_off').html(response.low_fuel.off)

		})
	}

	function getMap() {
		$.post(controller_url, { action: 'get_geradores' }, function (retorno) {
			console.log(retorno)
			var response=JSON.parse(retorno)
			
			// https://account.mapbox.com
			mapboxgl.accessToken = 'pk.eyJ1IjoiaXZhbmlsZG9lZSIsImEiOiJja2hmYWwxcWkwYWptMnhwYzk2c3lmNWJxIn0.MG7-GSqPrk3JCepjLMSB9Q';
			var map = new mapboxgl.Map({
				container: 'map',
				style: 'mapbox://styles/mapbox/streets-v8',
				center: [-24.24721217421829, 15.905888745235975],
				zoom: 7
			});

			map.on('load', function () {
				map.addSource('places', {
					'type': 'geojson',
					'data': {
						'type': 'FeatureCollection',
						'features': response.data
					}
				});
				// Add a layer showing the places.
				map.addLayer({
					'id': 'places',
					'type': 'symbol',
					'source': 'places',
					'layout': {
						'icon-image': 'marker-15',
						'icon-allow-overlap': true
					},
					"paint": {
						"icon-color": "#00ff00",
						"icon-halo-color": "#fff",
						"icon-halo-width": 2
					}
				});

				map.on('click', 'places', function (e) {
					var coordinates = e.features[0].geometry.coordinates.slice();
					var description = e.features[0].properties.description;
					while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
						coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
					}

					new mapboxgl.Popup()
						.setLngLat(coordinates)
						.setHTML(description)
						.addTo(map);
				});

				map.on('mouseenter', 'places', function () {
					map.getCanvas().style.cursor = 'pointer';
				});
				map.on('mouseleave', 'places', function () {
					map.getCanvas().style.cursor = '';
				});
			});
		})

	}

	function getMessage(type, message) {
		var text = '<div class="alert alert-sm alert-' + type + '" style="padding:4px">' + message + '</div>';

		$('.retorno').html(text);

		setTimeout(function () {
			$('.retorno').html('');
		}, 4000)
	}
});