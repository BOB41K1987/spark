$( document ).ready(function() {
    $( ".autocomplete" ).autocomplete({
        source: function( request, response ) {
            $.ajax( {
                url: Routing.generate('autocomplete'),
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function( data ) {
                    response( data );
                }
            } );
        },
        minLength: 2
    } );
});