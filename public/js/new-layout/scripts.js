
$(document).ready(function($){
	"use strict";

	$(window).scroll(function(){
            if ($(this).scrollTop() > 200) {
                $('#menu-fix').fadeIn(500);
            } else {
                $('#menu-fix').fadeOut(500);
            }
        });

	/////////TO TOP////////////
	function totop_button(a) {
		"use strict";
		var b = $("#back_to_top");
		b.removeClass("off on");
		if (a === "on") {
			b.addClass("on")
		} else {
			b.addClass("off")
		}
	}

    $(window).scroll(function() {
        var b = $(this).scrollTop();
        var c = $(this).height();
        var d;
        if (b > 0) {
            d = b + c / 2
        } else {
            d = 1
        }
		/* if (b > 60) {
             $("body").addClass("page-on-scroll")
        } else {
            $("body").removeClass("page-on-scroll")
        } */
        if (d < 1e3) {
            totop_button("off");
        } else {
            totop_button("on");
        }
    });


    $(document).on('click', '#back_to_top', function(e) {
        e.preventDefault();
        $('body,html').animate({
            scrollTop: 0
        }, $(window).scrollTop() / 3, 'linear');
    });

	//loader//
	$(window).load(function() {
		$('body').addClass('loaded');
	});

});

$(window).bind('resize', function (){

});