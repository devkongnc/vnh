function initMap(){map=new google.maps.Map(document.getElementById("estate-map"),{center:{lat:-34.397,lng:150.644},zoom:13}),marker=new google.maps.Circle({strokeColor:"#FF0000",strokeOpacity:.8,strokeWeight:2,fillColor:"#FF0000",fillOpacity:.35,map:map,center:{lat:-34.397,lng:150.644},radius:200}),geocoder=new google.maps.Geocoder,infowindow=new google.maps.InfoWindow}var map,marker,geocoder,infowindow;$(".item-details > .position-icon").click(function(e){e.preventDefault(),$(this).parent(".item-details").prev(".item-thumbnail").find(".position-icon").trigger("click")}),$("#modal-position").on("shown.bs.modal",function(e){e.preventDefault();var o=$(e.relatedTarget),t=new google.maps.LatLng(parseFloat(o.data("lat")),parseFloat(o.data("lng")));google.maps.event.trigger(map,"resize"),map.setCenter(t),marker.setCenter(t)});