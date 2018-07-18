/**
 * Created by DESIGN on 05/05/2016.
 */
var tinymceOptions = {
    selector: 'textarea',
    language : 'pt_BR',
    height: 400,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code textcolor colorpicker jbimages'
    ],
    toolbar: 'insertfile undo redo | styleselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages',
    content_style: "body {font-size: 13px !important}",

    relative_urls: false
};
