(function( $ ) {

    $( '#start-date' ).datepicker({
        dateFormat: 'yyyy-mm-dd',
        onClose: function( selectedDate ){
            $( '#end-date' ).datepicker( 'option', 'minDate', selectedDate);
        }
    });
    $( '#end-date' ).datepicker({
        dateFormat: 'yyyy-mm-dd',
        onClose: function( selectedDate ){
            $( '#start-date' ).datepicker(  'option', 'maxDate', selectedDate);
        }
    });

})( jQuery );
