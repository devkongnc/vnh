$(document).ready(function ($) {
    "use strict";

    $('.clear-form-search-btn').click(function (e) {
    });

    $(window).scroll(function () {
        if ($(document).width() > 767) {
            if ($(this).scrollTop() > 200) {
                $('#menu-fix').fadeIn(500);
            } else {
                $('#menu-fix').fadeOut(500);
            }
        } else {
            $('#menu-fix').show();
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

    $(window).scroll(function () {
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


    $(document).on('click', '#back_to_top', function (e) {
        e.preventDefault();
        $('body,html').animate({
            scrollTop: 0
        }, $(window).scrollTop() / 3, 'linear');
    });

    //loader//
    $(window).load(function () {
        $('body').addClass('loaded');
    });

    var search_content_collapse = $('.content-m.search-header .advanced-search');
    $('.mobile_search_top_toggle').click(function () {
        if (search_content_collapse.is(":visible")) {
            search_content_collapse.hide();
        } else {
            search_content_collapse.show();
        }
    });

    //------------//
    // SEARCH BOX //
    //------------//
    var price_max_search = 100;
    var price_min_search = 0;
    var size_max_search = 3000;
    var size_min_search = 0;

    function ajaxSearch() {
        var frontSearch = $("form[id='front-search']");
        $.ajax({
            url: frontSearch.attr('action'),
            data: frontSearch.serialize(),
            processData: false,
            type: 'get',
            success: function (data) {
                $("h2[id='total-estate']").text(data);
            }
        });
    }

    //dropdown checekbox//
    var options = [];
    $('.advanced-search .dropdown-menu a').on('click', function (event) {
        //console.log($(event.currentTarget));

        var $target = $(event.currentTarget),
            val = $target.attr('data-value'),
            $inp = $target.find('input'),
            elem_val = $inp.attr('value'),
            idx;

        if ($(this).closest('.menu-fix').length) {
            var sync_element = $('.search-header').find('ul.dropdown-menu').find('input[value="'+elem_val+'"]');
        } else {
            var sync_element = $('.menu-fix').find('ul.dropdown-menu').find('input[value="'+elem_val+'"]');
        }

        if ((idx = options.indexOf(val)) > -1) {
            options.splice(idx, 1);
            setTimeout(function () {
                $inp.prop('checked', false);
                sync_element.prop('checked', false);
                ajaxSearch();
            }, 0);
        } else {
            options.push(val);
            setTimeout(function () {
                $inp.prop('checked', true);
                sync_element.prop('checked', true);
                ajaxSearch();
            }, 0);
        }
        $(event.target).blur();
        return false;
    });

    var jrange_width = $(document).width() > 768 ? 330 : 768;

    $('.range-slider').jRange({
        from: 0,
        to: price_max_search,
        step: 1,
        scale: [price_min_search, price_max_search],
        format: '%s',
        width: jrange_width,
        showLabels: true,
        isRange: true,
        ondragend: function (data) {
            var range = data.split(",");
            sync_search_box('price-min',range[0]);
            sync_search_box('price-max',range[1]);
            ajaxSearch();
        },
        onbarclicked: function (data) {
            var range = data.split(",");
            sync_search_box('price-min',range[0]);
            sync_search_box('price-max',range[1]);
            ajaxSearch();
        }
    });
    $('.range-slider2').jRange({
        from: 0,
        to: size_max_search,
        step: 1,
        scale: [size_min_search, size_max_search],
        format: '%s',
        width: jrange_width,
        showLabels: true,
        isRange: true,
        ondragend: function (data) {
            var range = data.split(",");
            sync_search_box('size-min',range[0]);
            sync_search_box('size-max',range[1]);
            ajaxSearch();
        },
        onbarclicked: function (data) {
            var range = data.split(",");
            sync_search_box('size-min',range[0]);
            sync_search_box('size-max',range[1]);
            ajaxSearch();
        }
    });
    $(".num_only").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl/cmd+A
            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: Ctrl/cmd+C
            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: Ctrl/cmd+X
            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    //PRICE
    $("input#price-min").bind('change keyup', function (e) {
        if ($(this).closest('.menu-fix').length) {
            var price_min = parseInt($('.menu-fix input#price-min').val());
            var price_max = parseInt($('.menu-fix input#price-max').val());
        } else {
            var price_min = parseInt($('.search-header input#price-min').val());
            var price_max = parseInt($('.search-header input#price-max').val());
        }
        setTimeout(function () {
            if (isNaN(price_min)) { price_min = 0; }
            if (isNaN(price_max) || price_min > price_max) {
                price_max = price_max_search;
                sync_search_box('price-max',price_max);
            }
            if (price_min <= price_max) {
                sync_search_box('price-min',price_min);
                ajaxSearch();
            }
        }, 100);
    });

    $("input#price-max").bind('change keyup', function (e) {
        if ($(this).closest('.menu-fix').length) {
            var price_min = parseInt($('.menu-fix input#price-min').val());
            var price_max = parseInt($('.menu-fix input#price-max').val());
        } else {
            var price_min = parseInt($('.search-header input#price-min').val());
            var price_max = parseInt($('.search-header input#price-max').val());
        }
        setTimeout(function () {
            if (isNaN(price_min)) {
                price_min = 0;
                sync_search_box('price-min',price_min);
            }
            if (isNaN(price_max)
                || price_max > price_max_search) { price_max = price_max_search; }
            if (price_max >= price_min) {
                sync_search_box('price-max',price_max);
                ajaxSearch();
            }
        }, 100);
    });


    //AREA
    $("input#area-min").bind('change keyup', function (e) {
        if ($(this).closest('.menu-fix').length) {
            var size_min = parseInt($('.menu-fix input#area-min').val());
            var size_max = parseInt($('.menu-fix input#area-max').val());
        } else {
            var size_min = parseInt($('.search-header input#area-min').val());
            var size_max = parseInt($('.search-header input#area-max').val());
        }
        setTimeout(function () {
            if (isNaN(size_min)) { size_min = 0; }
            if (isNaN(size_max) || size_min > size_max) {
                size_max = size_max_search;
                sync_search_box('size-max',size_max);
            }
            if (size_min <= size_max) {
                sync_search_box('size-min',size_min);
                ajaxSearch();
            }
        }, 100);
    });

    $("input#area-max").bind('change keyup', function (e) {
        if ($(this).closest('.menu-fix').length) {
            var size_min = parseInt($('.menu-fix input#area-min').val());
            var size_max = parseInt($('.menu-fix input#area-max').val());
        } else {
            var size_min = parseInt($('.search-header input#area-min').val());
            var size_max = parseInt($('.search-header input#area-max').val());
        }
        setTimeout(function () {
            if (isNaN(size_min)) {
                size_min = 0;
                sync_search_box('size-min',size_min);
            }
            if (isNaN(size_max)
                || size_max > size_max_search) { size_max = size_max_search; }
            if (size_max >= size_min) {
                sync_search_box('size-max',size_max);
                ajaxSearch();
            }
        }, 100);
    });


    //------------//
    // SEARCH MAP //
    //------------//
    var frontSearch = $(".search-header form");
    $('#btn-open-map').click(function(){
        $('input#ne_lat').val('');
        $('input#ne_lng').val('');
        $('input#sw_lat').val('');
        $('input#sw_lng').val('');
        $("input#see_first").val('');
        window.location.href = 'search-map?'+frontSearch.serialize();
    });

    $('#btn-close-map').click(function() {
        $('input#ne_lat').val('');
        $('input#ne_lng').val('');
        $('input#sw_lat').val('');
        $('input#sw_lng').val('');
        $("input#see_first").val('');
        window.location.href = 'search?' + frontSearch.serialize();
    });


});

function sync_search_box(item, value) {
    switch(item) {
        case 'price-max':
            $('input#price-max').val(value);
            var price_min = $('input#price-min').val();
            $('.range-slider').jRange('setValue', ""+price_min+","+value);
            break;
        case 'price-min':
            $('input#price-min').val(value);
            var price_max = $('input#price-max').val();
            $('.range-slider').jRange('setValue', ""+value+","+price_max);
            break;
        case 'size-max':
            $('input#area-max').val(value);
            var size_min = $('input#area-min').val();
            $('.range-slider2').jRange('setValue', ""+size_min+","+value);
            break;
        case 'size-min':
            $('input#area-min').val(value);
            var size_max = $('input#area-max').val();
            $('.range-slider2').jRange('setValue', ""+value+","+size_max);
            break;
        default:
            break;
    }
}

$(window).bind('resize', function () {

});