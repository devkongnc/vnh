$.extend( true, $.fn.dataTable.defaults, {
    stateSave: true,
    order: [],
    pageLength: 25,
    columnDefs: [ {
        orderable: false,
        className: 'select-checkbox',
        targets:   0
    }],
    select: {
        style:    'os',
        selector: 'td:first-child'
    },
    dom: 'lfiprtp',
    language: {
        url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/' + current_lang_name + '.json'
    }
});

$kcfinder         = $("#kcfinder-single-select");
$images_container = $('.images-container');
$add_media        = $('#insert-media-button');
$upload_single    = $('#upload-single');
$upload_multi     = $('#upload-multi');
$modal_upload     = $('#modal-upload');
images_html       = '';
images_array      = [];

Dropzone.autoDiscover = false;

dropzone_single = new Dropzone("#upload-single", {
    url: '/admin/resource/upload',
    maxFilesize: 3,
    paramName: 'upload[]',
    thumbnailWidth: 150,
    thumbnailHeight: 150,
    acceptedFiles: 'image/*',
    sending: function(file, xhr, formData) {
        formData.append("dir", 'images');
    },
    success: function(file, response) {
        $kcfinder.find("img")[0].src = response[0].url;
        $kcfinder.find("input")[0].value = response[0].id;
        $kcfinder.find('.set-featured').addClass('hidden');
        $kcfinder.find('.remove-featured').removeClass('hidden');
        $modal_upload.modal('hide');
    }
});

dropzone_multi = new Dropzone("#upload-multi", {
    url: '/admin/resource/upload',
    parallelUploads: 5,
    maxFilesize: 3,
    paramName: 'upload',
    uploadMultiple: true,
    thumbnailWidth: 150,
    thumbnailHeight: 150,
    acceptedFiles: 'image/*',
    sending: function(file, xhr, formData) {
        formData.append("dir", 'images');
    },
    successmultiple: function(files, response) {
        images_html = '';
        for (var i = 0; i < response.length; i++) {
            images_html += '<li class="item"><img src="' + response[i].url + '" class="img-responsive" width="300" height="300" alt=""><input type="hidden" name="images[]" value="' + response[i].id + '"><button class="resource-delete" type="button">X</button></li>';
        }
        $images_container.append(images_html);
        $modal_upload.modal('hide');
    }
});

function openKCFinder(callback, targetID) {
    targetID = (typeof targetID !== 'undefined') ? targetID : 'kcfinder_div';
    var instance = document.getElementById(targetID);
    window.KCFinder = {
        callBack: function(files) {
            window.KCFinder = null;
            instance.style.display = 'none';
            callback(files);
        }
    };
    if (instance.innerHTML.trim() === '') {
        instance.innerHTML = "<div class='css3-loading container'> <div class='loader'> <div class='loader--dot'></div> <div class='loader--dot'></div> <div class='loader--dot'></div> <div class='loader--dot'></div> <div class='loader--dot'></div> <div class='loader--dot'></div> <div class='loader--text'></div> </div> </div>" + '<button type="button" onclick="this.parentElement.style.display=\'none\'">X</button><iframe name="kcfinder_iframe" src="/kcfinder/browse.php?opener=vnhouse&type=images" frameborder="0" width="100%" height="100%" marginwidth="0" marginheight="0" scrolling="no" />';
        instance.style.display = 'block';
        document.querySelector('#' + targetID + ' iframe').onload = function() {
            document.querySelector('#' + targetID + ' .css3-loading').style.display = 'none';
        };
    } else instance.style.display = 'block';
}

$(document).ready(function(){
    $("body").on('click', "[data-tab-lang]", function(evt){
        var ele = $(evt.target);
        $("[data-tab-lang=" + ele.attr('data-tab-lang') + "]").tab('show');
    });

    $('.ckeditor').each(function(index, el){
        $(el).attr('id', 'ckeditor_' + index);
        CKEDITOR.replace('ckeditor_' + index);
    });

    $('.datetimepicker').datepicker({
        orientation: "top left",
        autoclose: true,
        todayHighlight: true,
        language: current_locale
    });

    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
    });

    $('select').select2();

    $kcfinder.on('click', 'img', function(event) {
        event.preventDefault();
        $kcfinder.find('.set-featured').trigger('click');
        /*openKCFinder(function(files) {
            $kcfinder.find("img")[0].src = files[0].url;
            $kcfinder.find("input")[0].value = files[0].id;
            $kcfinder.find('.set-featured').addClass('hidden');
            $kcfinder.find('.remove-featured').removeClass('hidden');
        });*/
    }).on('click', '.remove-featured', function(event) {
        event.preventDefault();
        $kcfinder.find("img")[0].src = 'http://placehold.it/300x300';
        $kcfinder.find("input")[0].value = '';
        $kcfinder.find('.set-featured').removeClass('hidden');
        $kcfinder.find('.remove-featured').addClass('hidden');
    });

    $images_container.sortable({
        items: '> .item',
        cursor: "move"
    }).on('click', '.item > .resource-delete', function(event) {
        event.preventDefault();
        $(this).parent('.item').detach();
    });

    /*$add_media.click(function(event) {
        images_array = $images_container.find('.item > input').map(function(index, elem) {
            return parseInt($(elem).val());
        }).get();
        openKCFinder(function(files) {
            images_html = '';
            for (var i = 0; i < files.length; i++) {
                if ($.inArray(files[i].id, images_array) !== -1) continue;
                images_html += '<li class="item"><img src="' + files[i].url + '" class="img-responsive" alt=""><input type="hidden" name="images[]" value="' + files[i].id + '"><button class="resource-delete" type="button">X</button></li>';
            }
            $images_container.append(images_html);
        }, 'kcfinder_div2');
    });*/
    $modal_upload.on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        if (button.hasClass('set-featured')) $upload_single.removeClass('hidden');
        else if (button.hasClass('multi')) $upload_multi.removeClass('hidden');
    }).on('hidden.bs.modal', function() {
        dropzone_single.removeAllFiles();
        dropzone_multi.removeAllFiles();
        $upload_single.addClass('hidden');
        $upload_multi.addClass('hidden');
    });
});
