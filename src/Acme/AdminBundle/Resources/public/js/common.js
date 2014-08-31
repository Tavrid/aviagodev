$(document).ready(function(){
    if ($('.useEditor').length > 0) {
        $('.useEditor').each(function(){
            var ckeditorContent =  CKEDITOR.replace(this,{language: 'ru'});
            AjexFileManager.init({returnTo: 'ckeditor', editor: ckeditorContent});

        });
    }
    CKEDITOR.config.extraAllowedContent = 'a[!href,data-toggle]';
});