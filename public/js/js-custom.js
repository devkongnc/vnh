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

function add_like(estate_id) {
    like_ids.push(estate_id);
    localStorage.setItem("like_ids", JSON.stringify(like_ids));
    $num_like.text(like_ids.length);
    $('#nav').find('.like-page > a').addClass('active');
    setTimeout(function() {
        $('#nav').find('.like-page > a').removeClass('active');
    }, 1000);
    $('.btn-like[data-id="' + estate_id.toString() + '"]').addClass('active');
    // console.log(like_ids.length);
}

function remove_like(estate_id) {
    like_ids.splice(like_ids.indexOf(estate_id), 1);
    localStorage.setItem("like_ids", JSON.stringify(like_ids));
    $num_like.text(like_ids.length);
    $('.btn-like[data-id="' + estate_id.toString() + '"]').removeClass('active');
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

// function ajax_search() {
//     $.ajax({
//         url: search_ajax,
//         type: 'GET',
//         data: $front_search.serialize().replace(/[^&]+=&/g, '').replace(/&[^&]+=$/g, ''),
//         success: function(response) {
//             $front_search.find('.right-hits > span').text(response);
//         }
//     });
// }

// var CaptchaCallback = function() {
//     grecaptcha.render('RecaptchaPopup', {'sitekey' : '6LetKSYTAAAAAMRT2rGgIk0EbZ8T25g_MJNfuXzi'});
//     if (document.getElementById('RecaptchaContact')) grecaptcha.render('RecaptchaContact', {'sitekey' : '6LetKSYTAAAAAMRT2rGgIk0EbZ8T25g_MJNfuXzi'});
//     else if (document.getElementById('RecaptchaEstate')) grecaptcha.render('RecaptchaEstate', {'sitekey' : '6LetKSYTAAAAAMRT2rGgIk0EbZ8T25g_MJNfuXzi'});
//     else if (document.getElementById('RecaptchaOwner')) grecaptcha.render('RecaptchaOwner', {'sitekey' : '6LetKSYTAAAAAMRT2rGgIk0EbZ8T25g_MJNfuXzi'});
// };

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

$(window).resize(function () {
    pickup_blk_item_same_height();
    benefit_item_same_height();
    category_item_same_height();
    recommend_item_square();
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
                // return false();
            });
        });

        $('.page').each(function(index, element){
            $(this).addClass('hide');
            if( index === 0 ){
                $(this).removeClass('hide');
            }
        });

        $(".search-hidden .advanced-search").hide();
        $(".open-search-hidden").on('click', function(e) {
              e.preventDefault();
              $(".search-hidden .advanced-search").fadeToggle(300);
              $(".open-search-hidden").toggleClass( "close-c" );

        });

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
                console.log(1);
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
        console.log(like_ids);
        $.get(estate_ajax, {ids: like_ids}, function(data) {
            console.log(data);
            $.each(data, function(index, val) {
                like_estates += '' +
                    '<div class="post-house col-xs-6 col-sm-4 col-md-2">' +
                        '<span class="hidden" data-id="' + val.id + '"></span>' +
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
        like_ids = null;
        $('.list-house-popup').html('');
        $num_like.text(0);
        $('.btn-like').removeClass('active');
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
    //$(".feature-img .slide-slick").slick({});
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

    /*Hover auto play slide About Me*/
    /*$('.three-grid-item-wrapper .three-grid-item').hover(function() {
        _this = $(this);
        _this.find('.slick-next').click();
        hoverabout = setInterval(function(e) { _this.find('.slick-next').click(); }, 2000);
    }, function(e) {
        clearInterval(hoverabout);
    });*/

    // End hover slide about me
    /*$('.review-categories-wrapper > p > a').click(function(event) {
        event.preventDefault();
        $('.review-categories-wrapper > p > a.text-primary').removeClass('text-primary');
        $(this).addClass('text-primary');
        var category = $('.review-categories-wrapper a.text-primary').data('category');
        $.get('/review', { category: category }, function(data){
            $("#review-ajax").html(data);
        });
    });*/

    // End hover slide about me
    if (typeof Cookies.get('three-grid') === 'undefined') Cookies.set('three-grid', 'thumbnail-view');
    $('input#' + Cookies.get('three-grid')).parent().addClass('active');
    $('#list-view').change(function(){
        Cookies.set('three-grid', 'list-view');
        window.location.reload();
        /*$three_grid.attr('class', 'three-grid list-view');
        setTimeout(function() {
            $(".three-grid-item > .item-thumbnail > .images").each(function(index, el) {
                $(el).data('owlCarousel').reinit();
            });
        }, 300);*/
    });
    $('#thumbnail-view').change(function(){
        Cookies.set('three-grid', 'thumbnail-view');
        window.location.reload();
        /*$three_grid.attr('class', "three-grid thumbnail-view");
        setTimeout(function() {
            $(".three-grid-item > .item-thumbnail > .images").each(function(index, el) {
                $(el).data('owlCarousel').reinit();
            });
        }, 300);*/
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
    /*$body.addClass('open');
    $popup_thankyou.addClass('opened').fadeIn().find('.sub-thankyou > span').text($('#contact-name').val());
    $popup_thankyou.find('.title-thankyou > span').css('opacity', 0);
    setTimeout(function() {
        $title_thankyou.css({ 'opacity': 1 });
        for (var i = 0; i <= $title_thankyou.children().size(); i++)
            $title_thankyou.children('span:eq(' + i + ')').delay(200 * i).animate({ 'opacity': 1 }, 10);
    }, 500);*/

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
});

$(document).ready(function ($) {
    "use strict";

    $('.clear-form-search-btn').click(function (e) {
    });

    $(window).scroll(function () {
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

    $('.range-slider').jRange({
        from: 0,
        to: price_max_search,
        step: 1,
        scale: [price_min_search, price_max_search],
        format: '%s',
        width: 330,
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
        width: 330,
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