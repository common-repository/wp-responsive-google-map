initMap();

function initMap() {

	var $map = jQuery('#mapImage');

	if ($map.data('position-latitude') == undefined) {
		return true;
	}

	var posLatitude = $map.data('position-latitude'), 
		posLongitude = $map.data('position-longitude'), 
		posCount = Math.min(posLatitude.length, posLongitude.length), 
		info = $map.data('info'), 
		titles = $map.data('titles'), 
		address = $map.data('address'),
		latlng = [], 
		streetlng = [], 
		i;

	for (i = 0; i < posCount; i++) {
		latlng.push(new google.maps.LatLng(posLatitude[i], posLongitude[i]));
	}


	var mapstyles = [ {
		"stylers" : [ {
			"invert_lightness" : false
		}, {
			"weight" : 0
		}, {
			"hue" : "black"
		}, {
			"visibility" : "on"
		}, {
			"saturation" : -100
		}, {
			"lightness" : 5
		}, {
			"gamma" : 1
		} ]
	} ];

	// Creating an object literal containing the properties we want to pass to the map

	var options = {
		disableDoubleClickZoom : true,
		//mapTypeControlOptions : {
		//	mapTypeIds : [ 'Styled' ]
		//},
		//mapTypeId : 'Styled',
		scrollwheel : true,
		panControl : true,
		zoomControl : true,
		mapTypeControl : false,
		scaleControl : true,
		streetViewControl : true,
		zoom : parseInt(rgmParams.zoomLevel),
		center : new google.maps.LatLng(rgmParams.mapCenterLat,
				rgmParams.mapCenterLong),
		overviewMapControl : true
	};

	var map = new google.maps.Map(document.getElementById('mapImage'), options), styledMapType = new google.maps.StyledMapType(
			mapstyles, {
				name : 'Styled'
			}), 
		markerImage = $map.data('marker-img'), 
		markerWidth = $map.data('marker-width'), 
		markerHeight = $map.data('marker-height');

	map.mapTypes.set('Styled', styledMapType);

	var imagemain = new google.maps.MarkerImage(rgmParams.imagesPath + 'marker.png', new google.maps.Size(markerWidth, markerHeight));
	var bounds = new google.maps.LatLngBounds();
	var infowindow = new google.maps.InfoWindow();

	if (posLatitude != '') {
		for (i = 0; i < latlng.length; i++) {
			var marker = new google.maps.Marker({
				position : latlng[i],
				map : map,
				zoom : parseInt(rgmParams.zoomLevel),
				icon : imagemain,
			});

			bounds.extend(marker.position);

			google.maps.event
					.addListener(
							marker,
							'click',
							(function(marker, i) {

								return function() {

									var content = '<div style="color:#333;"><b>'
										+ titles[i].replace(/=/g, '"')+"</b> <br/>"
										+ '<br/><div>'+address[i]+'</div>'
										
										+ ((info[i] != undefined) ? info[i].replace(/=/g, '"') : '')
											
										+ '</div>';

									var zoomLevel = parseInt(rgmParams.zoomLevel);

									infowindow.setContent(content);
									infowindow.open(map, marker);
									map.panTo(this.getPosition());
									map.setZoom(parseInt(rgmParams.zoomLevel));
									map.set('scrollwheel', true);

								}
							})(marker, i));

			google.maps.event.addListener(infowindow, 'closeclick', function() {
				map.fitBounds(bounds);
			});
		}
	}

}

google.maps.event.addDomListener(window, 'resize', initMap);
google.maps.event.addDomListener(window, 'load', initMap);
