(function ( $ ) {
 
    $.fn.bootstrapAlert = function( options ) {
 
        // This is the easiest way to have default options.
        var settings = $.extend({
            // These are the defaults.
            title: "Título",
            messages: ['Mensaje 1', 'Mensaje 2'],
            type:'warning',
            time:0
        }, options );
 
        // Greenify the collection based on the settings variable.
        return this.each(function() {
            var html='<div class="alert alert-'+settings.type+' alert-dismissible fade in"  id="custom-alert" role="alert">\
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
        <strong>'+settings.title+'</strong><br><br>\
        <ul>';
            for(var i=0; i<settings.messages.length;i++) {
                html+='<li>'+settings.messages[i]+'</li>\n';
            }
            
        html+='</ul>\
           </div>';
            html=$(html);
            $(this).append(html);
            setTimeout(function() {
                 html.alert('close');
            }, settings.time);
        });
 
    };
 
}( jQuery ));



$(document).ajaxError(function( event, jqxhr, settings, thrownError ) {
    if(jqxhr.status==401) {
        window.location.reload();
    }
});

