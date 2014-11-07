jQuery(document).ready(function($){
    $('#post').submit(function(event){
        var title = $('#title').val();
        if( title.length == 0 || title.replace(/\s/g,'').length == 0 ){
            event.preventDefault();
            $('div#notice').remove();
            $("<div id='notice' class='error below-h2'><p>A title is required for all updates.</p></div>").insertAfter('h2');
            alert("A title is required for all updates");
            $('#title').focus();
            $('#ajax-loading').hide();
            $('#publish').removeClass('button-primary-disabled');
        }
    });
});