
CKEDITOR.editorConfig = function( config )
{
        // Define changes to default configuration here. For example:
    config.skin = 'office2013';

    // config.uiColor = '#AADC6E';

    config.toolbar = [
        ['Source','-','NewPage','Preview','-','Templates'],
        ['Cut','Copy','Paste','PasteText','PasteFromWord'],
        ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
        '/',
        ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
        ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        ['BidiLtr', 'BidiRtl' ],
        ['Link','Unlink','Anchor'],
        '/',
        ['Image','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'],
        ['Styles','Format','Font','FontSize'],
        ['TextColor','BGColor'],
        ['Maximize', 'ShowBlocks']
        ];

    config.entities = false;
    //config.entities_latin = false;

    config.height = 300;

    //config.filebrowserBrowseUrl = '/kcfinder/browse.php?opener=ckeditor&type=files';
    //config.filebrowserImageBrowseUrl = '/kcfinder/browse.php?opener=ckeditor&type=images';
    config.filebrowserUploadUrl = '/admin/resource/upload';

};
