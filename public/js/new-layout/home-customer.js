$(document).ready(function() {
	alert('hello');
	$('.estate-recommend').each(function(index, element){
		if( index===0 ){
			$(this).find('a').addClass('active');
			var data = $(this).attr('value');
			$.ajax({
	            type: "get",
	            url: '/office/estate-detail',
	            data: {estate_id : data},
	            success: function( msg ) {
	                $("#pages").append(msg);
	            }
	        });
		}
		$(this).click(function () {
	        // e.preventDefault();
	        $('.estate-recommend').find('a').removeClass('active');
	        $(this).find('a').addClass('active');

	        var data = $(this).attr('value');
	        $.ajax({
	            type: "get",
	            url: '/office/estate-detail',
	            data: {estate_id : data},
	            success: function( msg ) {
	            	$("#pages").empty();
	                $("#pages").append(msg);
	            }
	        });
	        return false();
	    });
	});


	var slider = new Slider("#range-slider");
		slider.on("slide", function(value) {
		// console.log(value[0]);
		$('.input-min-price').val(value[0]);
		$('.input-max-price').val(value[1]);
	});

	var slider2 = new Slider("#range-slider2");
		slider2.on("slide", function(value) {
		// console.log(value[0]);
		$('.input-min-area').val(value[0]);
		$('.input-max-area').val(value[1]);
	});

	$(".search-hidden .advanced-search").hide();

	$(".open-search-hidden").on('click', function(e) {
		e.preventDefault()
		$(".search-hidden .advanced-search").fadeToggle(300);
		$(".open-search-hidden").toggleClass( "close-c" );
	 });
});
