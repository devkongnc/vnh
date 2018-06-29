var map, marker, geocoder, infowindow;

function initMap() {
    map = new google.maps.Map(document.getElementById('estate-map'), {
        center: { lat: -34.397, lng: 150.644 },
        zoom: 13
    });
    /*marker = new google.maps.Marker({
        position: { lat: -34.397, lng: 150.644 },
        map: map
    });*/
    marker = new google.maps.Circle({
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#FF0000',
        fillOpacity: 0.35,
        map: map,
        center: { lat: -34.397, lng: 150.644 },
        radius: 200,
    });
    geocoder = new google.maps.Geocoder();
    infowindow = new google.maps.InfoWindow();
}

$('.item-details > .position-icon').click(function(event) {
    event.preventDefault();
    $(this).parent('.item-details').prev('.item-thumbnail').find('.position-icon').trigger('click');
});

$('#modal-position').on('shown.bs.modal', function(event) {
    event.preventDefault();
    var button = $(event.relatedTarget),
        position = new google.maps.LatLng(parseFloat(button.data('lat')), parseFloat(button.data('lng')));
    google.maps.event.trigger(map, 'resize');
    /*geocoder.geocode({ 'location': position }, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                infowindow.setContent(results[1].formatted_address);
                infowindow.open(map, marker);
            } else {
                infowindow.close();
                console.log('No results found');
            }
        } else {
            infowindow.close();
            console.log('Geocoder failed due to: ' + status);
        }
    });*/
    map.setCenter(position);
    marker.setCenter(position);
});
