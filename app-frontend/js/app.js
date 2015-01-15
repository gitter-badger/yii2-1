window.app = (function ($) {
    var public = {};

    /* -- public variables -- */
    public.$body = $('body');
    public.$modal = public.$body.find('.modal');
    public.baseUrl = window.location.origin + '/';

    /* -- public methods -- */
    public.init = function () {
        ajaxSetup();
    };
    public.alert = function(mess, $class){
        var content = new EJS({
            url: public.baseUrl + 'templates/commons/alert'
        }).render({ mess: mess, class_name: $class });
        public.$modal.html(content).modal();
    };

    /* -- private methods -- */
    var ajaxSetup = function(){
        $.ajaxSetup({
            error: function(jqXhr, data, error) {
                var content = new EJS({
                    url: public.baseUrl + 'templates/commons/error_alert'
                }).render( {mess: jqXhr.responseText} );
                public.$modal.html(content).modal();
                return console.log(jqXhr.responseText);
            }
        });
    };

    return public;

})(jQuery);

jQuery( document ).ready(function() {
    app.init();
});
