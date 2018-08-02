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

/**
 * Global variables
 */
var like_ids          = localStorage.getItem('like_ids') || '[]',
    $body             = $('body'),
    $num_like         = $('.like-page .like-count'),
    $modal_like       = $('#modal-like'),
    $estates_contact  = $modal_like.find('.form-contact > .estate-ids.hidden'),
    $popup_thankyou   = $('.popup-thankyou'),
    $title_thankyou   = $('.title-thankyou'),
    $three_grid       = $('.three-grid'),
    $front_search     = $('#front-search'),
    $wrap_search_box  = $('.wrap-search-box'),
    $search_box       = $('.search-box'),
    $search_bar       = $search_box.children('.search-bar'),
    $btnCloseSearch   = $('.btn-close-search'),
    search_bar_height = $search_bar.css('height'),
    is_touch_device   = ('ontouchstart' in window || navigator.maxTouchPoints) && $(window).width() <= 1024,
    isMacLike         = navigator.platform.match(/(Mac|iPhone|iPod|iPad)/i) ? true : false,
    hoverabout        = null;
like_ids = JSON.parse(like_ids);

// Helpers
(function (factory) {
    var registeredInModuleLoader = false;
    if (typeof define === 'function' && define.amd) {
        define(factory);
        registeredInModuleLoader = true;
    }
    if (typeof exports === 'object') {
        module.exports = factory();
        registeredInModuleLoader = true;
    }
    if (!registeredInModuleLoader) {
        var OldCookies = window.Cookies;
        var api = window.Cookies = factory();
        api.noConflict = function () {
            window.Cookies = OldCookies;
            return api;
        };
    }
}(function () {
    function extend () {
        var i = 0;
        var result = {};
        for (; i < arguments.length; i++) {
            var attributes = arguments[ i ];
            for (var key in attributes) {
                result[key] = attributes[key];
            }
        }
        return result;
    }

    function init (converter) {
        function api (key, value, attributes) {
            var result;
            if (typeof document === 'undefined') {
                return;
            }

            // Write

            if (arguments.length > 1) {
                attributes = extend({
                    path: '/'
                }, api.defaults, attributes);

                if (typeof attributes.expires === 'number') {
                    var expires = new Date();
                    expires.setMilliseconds(expires.getMilliseconds() + attributes.expires * 864e+5);
                    attributes.expires = expires;
                }

                try {
                    result = JSON.stringify(value);
                    if (/^[\{\[]/.test(result)) {
                        value = result;
                    }
                } catch (e) {}

                if (!converter.write) {
                    value = encodeURIComponent(String(value))
                        .replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent);
                } else {
                    value = converter.write(value, key);
                }

                key = encodeURIComponent(String(key));
                key = key.replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent);
                key = key.replace(/[\(\)]/g, escape);

                return (document.cookie = [
                    key, '=', value,
                    attributes.expires ? '; expires=' + attributes.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                    attributes.path ? '; path=' + attributes.path : '',
                    attributes.domain ? '; domain=' + attributes.domain : '',
                    attributes.secure ? '; secure' : ''
                ].join(''));
            }

            // Read

            if (!key) {
                result = {};
            }

            // To prevent the for loop in the first place assign an empty array
            // in case there are no cookies at all. Also prevents odd result when
            // calling "get()"
            var cookies = document.cookie ? document.cookie.split('; ') : [];
            var rdecode = /(%[0-9A-Z]{2})+/g;
            var i = 0;

            for (; i < cookies.length; i++) {
                var parts = cookies[i].split('=');
                var cookie = parts.slice(1).join('=');

                if (cookie.charAt(0) === '"') {
                    cookie = cookie.slice(1, -1);
                }

                try {
                    var name = parts[0].replace(rdecode, decodeURIComponent);
                    cookie = converter.read ?
                        converter.read(cookie, name) : converter(cookie, name) ||
                        cookie.replace(rdecode, decodeURIComponent);

                    if (this.json) {
                        try {
                            cookie = JSON.parse(cookie);
                        } catch (e) {}
                    }

                    if (key === name) {
                        result = cookie;
                        break;
                    }

                    if (!key) {
                        result[name] = cookie;
                    }
                } catch (e) {}
            }

            return result;
        }

        api.set = api;
        api.get = function (key) {
            return api.call(api, key);
        };
        api.getJSON = function () {
            return api.apply({
                json: true
            }, [].slice.call(arguments));
        };
        api.defaults = {};

        api.remove = function (key, attributes) {
            api(key, '', extend(attributes, {
                expires: -1
            }));
        };

        api.withConverter = init;

        return api;
    }

    return init(function () {});
}));

var timeout_tooltip;
function add_like(estate_id) {
    clearTimeout(timeout_tooltip);
    like_ids.push(estate_id);
    localStorage.setItem("like_ids", JSON.stringify(like_ids));
    $num_like.text(like_ids.length);
    $('#nav').find('.like-page > a').addClass('active');
    setTimeout(function() {
        $('#nav').find('.like-page > a').removeClass('active');
    }, 1000);
    $('.btn-like[data-id="' + estate_id.toString() + '"]').addClass('active');

    //shake icon
    $('.like-page').addClass('shake');
    setTimeout(function() {
        $('.like-page').removeClass("shake");
    }, 700);

    //show popup add success
    $(".like-page[data-toggle='tooltip']").attr('data-original-title', txt_like_add).tooltip('show');
    $(".like-page").removeClass('none_selected');
    set_like_popup_text_current_startup();
    timeout_tooltip = setTimeout(function() {
        $(".like-page[data-toggle='tooltip']").tooltip('hide');
    }, 2500);
}

function set_like_popup_text_current_startup() {
    var text_current_like = txt_like_default_text;
    if (like_ids !== null && like_ids !== '' && like_ids.length > 0) {
        $(".like-page").removeClass('none_selected');
        text_current_like = txt_like_current.replace(':num', like_ids.length);
    } else {
        $(".like-page").addClass('none_selected');
    }
    $(".like-page[data-toggle='tooltip']").attr('data-original-title', text_current_like);

    $('.big-favorite-btn').each(function () {
        var $btn_like = $(this),
            estate_id = $btn_like.data('id');
        if (!$btn_like.hasClass('active') && $.inArray(estate_id, like_ids) === -1) {
            $btn_like.find('span').html(txt_bt_like_not_select);
        } else if ($.inArray(estate_id, like_ids) >= 0) {
            $btn_like.find('span').html(txt_bt_like_selected);
        }
    });

    $(like_ids).each(function (e,item) {
        $('.img-btn-like[data-id="'+item+'"]').removeClass('none_selected');
    });

}

function remove_like(estate_id) {
    clearTimeout(timeout_tooltip);
    $(".like-page[data-toggle='tooltip']").tooltip('hide');
    like_ids.splice(like_ids.indexOf(estate_id), 1);
    localStorage.setItem("like_ids", JSON.stringify(like_ids));
    $num_like.text(like_ids.length);
    $('.btn-like[data-id="' + estate_id.toString() + '"]').removeClass('active');
    set_like_popup_text_current_startup();
    $('.img-btn-like[data-id="'+estate_id+'"]').addClass('none_selected');
}

function resize_change(is_first) {
    is_first = typeof is_first !== 'undefined' ? is_first : false;
    var $width = $(window).width();
    if ($width < 992) {
        $('.wrap-search-box.home').appendTo('header.home').removeClass('hidden-xs hidden-sm');
        $search_box.removeClass('active');
    }
    else {
        $('.wrap-search-box.home').insertAfter('.banner-home').addClass('hidden-xs hidden-sm').css('display', '');
        $wrap_search_box.not('.home').find($search_box).addClass('active');
    }

    if ($width < 768) {
        //$('.news-life').insertBefore('.infomation-house');
        $('.home-toggle').each(function(index, el) {
            $(el).children('.toggle-container').children().insertBefore($(el));
        });
    } else if (!is_first) {
        //$('.news-life').insertAfter('.whatis-vnh');
        $('label.toggle-label').each(function(index, el) {
            var target = $('.home-toggle.' + $(el).attr('for')).find('.toggle-container'),
                checkbox = $(el).next('.toggle-checkbox');
            $(el).appendTo(target);
            checkbox.appendTo(target);
        });
    }
}

function shareSocial(type, title) {
    var shareLink = '', url = window.location.href;
    switch(type) {
        case 'facebook':
            shareLink = 'https://www.facebook.com/sharer/sharer.php?u=' + url;
            break;
        case 'pinterest':
            shareLink = 'http://pinterest.com/pin/create/button/?url=' + url;
            break;
        case 'google':
            shareLink = 'https://plus.google.com/share?url=' + url;
            break;
        case 'twitter':
            shareLink = 'https://twitter.com/home?status=' + url;
            break;
        case 'line':
            shareLink = 'http://line.me/R/msg/text/?' + escape(title) + '%0D%0A' + url;
            break;
        default:
            break;
    }
    if (shareLink === '') return;
    window.open(shareLink);
}


var resizeId;
if (!is_touch_device) {
    $(window).resize(function() {
        clearTimeout(resizeId);
        resizeId = setTimeout(resize_change, 500);
    });
}

function pickup_blk_item_same_height() {
    var maxHeight = 0;
    $(".pickup-blk").removeAttr("style");
    $('.pickup-blk').each(function () {
        if ($(this).height() > maxHeight) {
            maxHeight = $(this).height();
        }
    });
    $('.pickup-blk').height(maxHeight);
}

function benefit_item_same_height() {
    var maxHeight = 0;
    $(".benefit-blk").removeAttr("style");
    $('.benefit-blk').each(function () {
        if ($(this).height() > maxHeight) {
            maxHeight = $(this).height();
        }
    });
    $('.benefit-blk').height(maxHeight);
}

function category_item_same_height() {
    var maxHeight = 0;
    $(".highest-box").removeAttr("style");
    $('.highest-box').each(function () {
        if ($(this).height() > maxHeight) {
            maxHeight = $(this).height();
        }
    });
    $('.highest-box').height(maxHeight);
}

function recommend_item_square() {
    var i_width = $('.folio-recommend li').width();
    $('.folio-recommend li').each(function () {
        $(this).height(i_width);
        $(this).find('.gal-thumb span').width(i_width);
        $(this).find('img').height(i_width);
    });
}

function fixed_menu_on_resize() {
    if ($(document).width() <= 767) {
        $('#menu-fix').show();
    } else {
        $('#menu-fix').hide();
    }
}

function sp_toggle_aside_menu() {
    if ($('.aside').hasClass('in')) {
        $('.aside').asidebar('close');
    } else {
        $('.aside').asidebar('open');

        //close another popup
        $('#modal-like').modal('hide');
        $('.search-hidden section.wrap-search-box .advanced-search').hide('fast');
        $(".search-hidden").hide('fast');
    }
}

$(window).resize(function () {
    pickup_blk_item_same_height();
    benefit_item_same_height();
    category_item_same_height();
    recommend_item_square();
    fixed_menu_on_resize();
});


$(document).ready(function() {

        $('.estate-recommend').each(function(index, element){
            if( index===0 ){
                $(this).find('a').addClass('active');
            }
            $(this).click(function () {
                // e.preventDefault();
                $('.estate-recommend').find('a').removeClass('active');
                $(this).find('a').addClass('active');

                if ($(window).width()<768){
                    window.location.href = ('/office/'+$(this).attr('value'));
                }

            });
        });

        $('#show_map_button').click(function () {
            $('.house-list-map').fadeToggle();
        });

        $('.page').each(function(index, element){
            $(this).addClass('hide');
            if( index === 0 ){
                $(this).removeClass('hide');
            }
        });


        $(".open-search-hidden").on('click', function(e) {
              e.preventDefault();
              $(".search-hidden .advanced-search").fadeToggle(300);
              $(".open-search-hidden").toggleClass( "close-c" );
        });

        $(".sp-open-search-hidden, .close-btn.search-fixed").on('click', function(e) {
            e.preventDefault();
            $(".search-hidden").fadeToggle(300);
            $('.search-hidden section.wrap-search-box .advanced-search').fadeToggle();
            $(".sp-open-search-hidden").toggleClass( "close-c" );

            //close another popup
            $('#modal-like').modal('hide');
            $('.aside').asidebar('close');
        });

        $('#modal-like').on('shown.bs.modal', function (e) {
            //close another popup
            $('.aside').asidebar('close');
            $('.search-hidden section.wrap-search-box .advanced-search').hide('fast');
            $(".search-hidden").hide('fast');
        })

        $('.container-gallery').gallery({
            items: 10,
            thumbHeight: '50px',
            showThumbnails: true,
            singleLine: false,
            0: {
                thumbHeight:35,
                items: 10,
            },
            480: {
                height: 320,
                items: 10,
            },
            497: {
                height: 331,
                items: 10,
            },
            585: {
                height: 390,
                items: 10

            },
            600: {
                height: 445,
                items: 10
            },
            768: {
                height: 482,
                items: 10
            },
            991: {
                height: 300,
                items: 10
            },
        });

        $('.related-house-carousel').owlCarousel({
            loop:false,
            margin:10,
            nav:true,
            navText : ["",""],
            dots:false,
            responsive:{
                0:{
                    items:1
                },
                481:{
                    items:2
                },
                768:{
                    items:5
                },
                992:{
                    items:5
                },
                1200:{
                    items:5
                },
                1480:{
                    items:6
                }
            }
        });

        $('.house-carousel').owlCarousel({
            loop:true,
            margin:0,
            thumbHeight: '200px',
            nav:true,
            navText : ["",""],
            dots:false,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });

        $('.label-intro').owlCarousel({
            loop:true,
            margin:0,
            autoplay:true,
            nav:false,
            dots:false,
            animateOut: 'fadeOut',
            animateIn: 'flipInY',
            responsive:{
                0:{
                    items:1
                },
                481:{
                    items:1
                },
                992:{
                    items:1
                },
                1200:{
                    items:1
                },
                1480:{
                    items:1
                }
            }
        });

        $("#folio li a").on('click', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            $("#pages .page:not('.hide')").stop().fadeOut('fast', function() {
                $(this).addClass('hide');
                $('#pages .page[data-page="'+page+'"]').fadeIn('slow').removeClass('hide');
            });
           $('#folio li a').removeClass('active');
            $(this).addClass('active');
        });
    // add new 2018-05-17 end

    resize_change(true);

    if (isMacLike) {
        $('head').append('<style type="text/css">' +
            'article > .breadcrumb > a::after {top: -1px;}' +
        '</style>');
    }

    if (is_touch_device) {
        $btnCloseSearch.children('span').attr('class', 'icon-close');
        $btnCloseSearch.off('click').on('click', function(event) {
            event.preventDefault();
            $(this).find('.btn-open').toggleClass('icon-arrow-down icon-arrow-up');
            $('body header').toggleClass('toggle-search');
            $wrap_search_box.fadeToggle('fast');
        });
    }

    if ($('header').hasClass('page-home')) {
        $('.toggle-label').click(function(event) {
            $(this).toggleClass('active');
        });

        $('#menu-trigger').change(function() {
            if (this.checked && !$('#sticky-wrapper').hasClass('is-sticky')) {
                $('header.home').addClass('black');
            } else {
                $('header.home').removeClass('black');
            }
            $body.toggleClass('open');
        });


        $("img.lazy").lazyload({ threshold : 200 });
        if ($(window).width() > 1024) $("header").sticky({topSpacing: 0, zIndex: 10});

        /* Event Advanced Search */
        $btnCloseSearch.on('click', function() {
            if (!$search_box.hasClass('active')) {
                $search_bar.animate({ height: 350 }, 100);
                setTimeout(function() {
                    $search_box.toggleClass('active');
                }, 200);
                $(this).children('span').attr('class', 'icon-close');
                //$('article.home-content').append("<div class='prop-overlay'></div>");
            } else {
                $search_bar.animate({ height: search_bar_height }, 100);
                setTimeout(function() {
                    $search_box.toggleClass('active');
                }, 200);
                $(this).children('span').attr('class', 'icon-arrow-down');
                //$('article.home-content .prop-overlay').remove();
            }
        });
    } else {
        $('#menu-trigger').change(function() {
            $body.toggleClass('open');
        });

        $btnCloseSearch.children('span').attr('class', 'icon-close');
        $btnCloseSearch.on('click', function(event) {
            event.preventDefault();
            $wrap_search_box.fadeToggle('fast');
            $body.toggleClass('open');
        });
    }

    $('.language > .toggle').click(function(event) {
        event.preventDefault();
        $(this).next().toggleClass('open');
    });


    $('.type-house .list-type .tab-type').on('click', ' > a', function() {
        _this = $(this);
        _this.parent().toggleClass('opened');
        _this.next().slideToggle('slow');
    });


    /* Popup like */
    $num_like.text(like_ids.length);

    $modal_like.on('shown.bs.modal', function() {
        var like_estates = '', input_estates = '';
        $.get(estate_ajax, {ids: like_ids}, function(data) {
            $.each(data, function(index, val) {
                like_estates += '' +
                    '<div class="post-house col-xs-6 col-sm-4 col-md-3">' +
                        '<span class="hidden" data-id="' + val.product_id + '"></span>' +
                        '<a target="_blank" href="' + estate_permalink(val.product_id) + '">' +
                            '<div class="feature-image">' +
                                '<img class="img-responsive" src="' + val.post_thumbnail + '" />' +
                                '<div class="item-brief">' +
                                    '<span class="price">' + val.price + '' +(val.price_max > 0 ? ' ~ '+val.price_max : '')+
                                    '<small> USD/㎡</small></span>' +
                                    '<span class="position pull-right">１区</span>' +
                                '</div>' +
                            '</div>' +
                            '<div class="title">' + val.title + '</div>' +
                        '</a>' +
                        '<a class="close-house">' +
                            '<span class="icon-close-light" data-dismiss="modal">' +
                                '<span class="path1"></span>' +
                                '<span class="path2"></span>' +
                            '</span>' +
                        '</a>' +
                    '</div>';
                input_estates += '<input type="hidden" name="estates[]" value="' + val.id + '" />';
            });
            $modal_like.find('.list-house-popup').html(like_estates);
            $estates_contact.html(input_estates);
        });
    });

    $('.list-house-popup').on('click', '.post-house > .close-house', function(event) {
        event.preventDefault();
        var estate_id = $(this).siblings('.hidden').data('id');
        remove_like(estate_id);
        $estates_contact.find('input[value="' + estate_id + '"]').detach();
        $(this).parent('.post-house').detach();
    });
    $('.clear-like').click(function(event) {
        event.preventDefault();
        localStorage.removeItem("like_ids");
        like_ids = [];
        $('.list-house-popup').html('');
        $num_like.text(0);
        $('.btn-like').removeClass('active');
        $('.img-btn-like:not(.img-responsive)').addClass('none_selected');
        set_like_popup_text_current_startup();
    });
    $('.top-news .like, #single-sidebar > .last-updated > .like, .btn-like').on('click touchstart', function(event) {
        event.preventDefault();
        var estate_id = $(this).data('id');
        if (!$(this).hasClass('active') && $.inArray(estate_id, like_ids) === -1) add_like(estate_id);
        else if ($.inArray(estate_id, like_ids) >= 0) remove_like(estate_id);
    });
    $('.btn-like').each(function(index, el) {
        if ($.inArray($(el).data('id'), like_ids) >= 0) $(el).addClass('active');
    });

    /*Hight Rise Apartment Tab*/
    $(".tab-hightrise .tab-content .cont-tab .right-tab .owl-tab").owlCarousel({
        navigation: true,
        pagination: false,
        slideSpeed: 1000,
        lazyLoad: true,
        paginationSpeed: 1000,
        singleItem: true,
    });

    /* Open Top Bar Search */
    $('.top-bar-search, .right-top > .search-phone, .search_home_custom .search-phone').on('click', function(event) {
        event.preventDefault();
        $(this).find('.btn-open').toggleClass('icon-arrow-down icon-arrow-up');
        $('body header').toggleClass('toggle-search');
        if ($(window).width() < 992) $("html, body").scrollTop(0);
        else $body.toggleClass('open');
        $wrap_search_box.fadeToggle('fast');
    });


    /* Slick Slide related post */
    $(".three-grid .images").owlCarousel({
        navigation: true,
        pagination: false,
        slideSpeed: 1000,
        lazyLoad: true,
        paginationSpeed: 1000,
        singleItem: true,
        autoPlay: false,
        afterLazyLoad: function(element) {
            element.nextAll("a").each(function () {
                $(this).children('img').attr("src", function () {
                    return $(this).data("src");
                })
            })
        }
    });

    // End hover slide about me
    if (typeof Cookies.get('three-grid') === 'undefined') Cookies.set('three-grid', 'thumbnail-view');
    $('input#' + Cookies.get('three-grid')).parent().addClass('active');
    $('#list-view').change(function(){
        Cookies.set('three-grid', 'list-view');
        window.location.reload();
    });
    $('#thumbnail-view').change(function(){
        Cookies.set('three-grid', 'thumbnail-view');
        window.location.reload();
    });

    /* Popup Arigato and Validate Form Contact */
    $title_thankyou.children().andSelf().contents().each(function() {
        if (this.nodeType == 3) {
            $(this).replaceWith($(this).text().replace(/(\S)/g, '<span>$1</span>'));
        }
    });
    $('.form-contact:not(.no-ajax)').submit(function(event) {
        event.preventDefault();
        var self = $(this),
            $contact_errors =  self.children('.contact-errors'),
            $ajax_loader = self.find('.ajax-loader'),
            prefix = self.data('prefix'),
            errors = '';
        $.ajax({
            url: self.attr('action'),
            type: 'POST',
            data: self.serialize(),
            beforeSend: function() {
                $ajax_loader.removeClass('hidden');
            }
        }).done(function(response) {
            switch (response.status) {
                case 'error-validate':
                    $.each(response.message, function(index, val) {
                        errors += '<p class="error">' + val + '</p>';
                        $('#' + prefix + '-' + index).addClass('error');
                    });
                    $contact_errors.html(errors);
                    break;
                case 'error-mail':
                    errors = '<p class="error">' + response.message + '</p>';
                    $contact_errors.html(errors);
                    break;
                case 'success':
                    $('#modal-like').modal('hide');
                    $('#modal-like-single').modal('hide');
                    $body.append(response.popup);
                    $body.addClass('open');
                    $('.popup-thankyou').addClass('opened').fadeIn().find('.sub-thankyou > span').text($('#contact-name').val());
                    $('.popup-thankyou').find('.title-thankyou > span').css('opacity', 0);
                    setTimeout(function() {
                        $title_thankyou   = $('.title-thankyou');
                        $title_thankyou.css({ 'opacity': 1 });
                        for (var i = 0; i <= $title_thankyou.children().size(); i++)
                            $title_thankyou.children('span:eq(' + i + ')').delay(200 * i).animate({ 'opacity': 1 }, 10);
                    }, 500);
                    self[0].reset();
                    break;
                default:
                    break;
            }
        }).always(function() {
            $ajax_loader.addClass('hidden');
        });
    });
    $body.on('click', '.overlay-bg, .close-thankyou, .box-thankyou > .btn-bottom > .btn-close', function(event) {
        event.preventDefault();
        $body.removeClass('open');
        $('.popup-thankyou').removeClass('opened').fadeOut();
    });

    $body.on('.close-thankyou, .box-thankyou > .btn-bottom > .btn-close', function(event) {
        event.preventDefault();
        window.location.href = window.location.origin + "/" + $body[0].classList[0];
    });

    $('.label-toggle').click(function(event) {
        if ($(this).prop('tagName') === 'A') event.preventDefault();
        $(this).toggleClass('active');
    });

    $.fn.textWidth = function(text, font) {
        if (!$.fn.textWidth.fakeEl) $.fn.textWidth.fakeEl = $('<span>').hide().appendTo(document.body);
        $.fn.textWidth.fakeEl.text(text || this.val() || this.text()).css('font', font || this.css('font'));
        return $.fn.textWidth.fakeEl.width();
    };

    pickup_blk_item_same_height();
    benefit_item_same_height();
    category_item_same_height();
    recommend_item_square();
    fixed_menu_on_resize();

    $(".like-page[data-toggle='tooltip']").tooltip({html: true, placement: "bottom"});
    set_like_popup_text_current_startup();

    $('.house-blk').click(function (e) {
        var link = $(this).data('link');
        if($(event.target).is('.owl-prev,.owl-next,.btn-like,.img-btn-like')) {
            event.preventDefault();
        } else {
            window.location.href = link;
        }
    });
});

$(document).ready(function ($) {
    "use strict";

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

    $('.bt-group-search-condition > li > a').click(function () {
        if ($(this).hasClass('box-active')) {
            $('.box-active').removeClass('box-active');
        } else {
            $('.box-active').removeClass('box-active');
            $(this).addClass('box-active');
            $(this).parent().find('ul').addClass('box-active');
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

    function change_style_dropdown() {
        if ($('.search-header input[name="term[area][]"]:checked').length > 0) {
            $('button#dropdownselect3').addClass('selected_area').text(txt_bt_area_selected);
        } else {
            $('button#dropdownselect3').removeClass('selected_area').text(txt_bt_area_default);
        }
    }

    //dropdown checkbox//
    var options = [];
    var term_area_selected = $('.search-header input[name="term[area][]"]:checked');

    $(term_area_selected).each(function () {
        options.push($(this).closest('a').attr('data-value'));
    });

    $('.advanced-search .dropdown-menu a').on('click', function (event) {
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

        console.log(options);
        if ((idx = options.indexOf(val)) > -1) {
            options.splice(idx, 1);
            setTimeout(function () {
                $inp.prop('checked', false);
                sync_element.prop('checked', false);
                change_style_dropdown();
                ajaxSearch();
            }, 0);
        } else {
            options.push(val);
            setTimeout(function () {
                $inp.prop('checked', true);
                sync_element.prop('checked', true);
                change_style_dropdown();
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
        step: 50,
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

    $(".search-hidden .advanced-search").hide();

    $('.search-condition-item.price-condition button[type="reset"]').click(function () {
        setTimeout(function() {
            var price_min = parseInt($('.search-condition-item.price-condition input#price-min').val());
            var price_max = parseInt($('.search-condition-item.price-condition input#price-max').val());
            sync_search_box('price-min',price_min);
            sync_search_box('price-max',price_max);
        }, 1);
    });
    $('.search-condition-item.size-condition button[type="reset"]').click(function () {
        setTimeout(function() {
            var size_min = parseInt($('.search-condition-item.size-condition input#area-min').val());
            var size_max = parseInt($('.search-condition-item.size-condition input#area-max').val());
            sync_search_box('size-min',size_min);
            sync_search_box('size-max',size_max);
        }, 1);
    });

    $('.clear-form-search-btn').click(function () {
        // $('.range-slider').jRange('setValue', ""+price_min_search+","+price_max_search);
        // $('.range-slider2').jRange('setValue', ""+size_min_search+","+size_max_search);
        sync_search_box('price-min',price_min_search);
        sync_search_box('price-max',price_max_search);
        sync_search_box('size-min',size_min_search);
        sync_search_box('size-max',size_max_search);
        $('input#keyword').val('');
        $('.advanced-search .dropdown-menu a').find('input[type="checkbox"]').prop('checked', false);
        change_style_dropdown();
        ajaxSearch();
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

    //KEYWORD
    var form_keyword = $('form[id="front-search"] input#keyword');
    $(form_keyword).bind('change keyup', function (e) {
        var form_keyword_txt =  $(this).val();
        form_keyword.val(form_keyword_txt);
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
