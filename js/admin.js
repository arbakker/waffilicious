(function( $ ) {

    $( '#start-date' ).datepicker({
        dateFormat: 'dd MM, yy',
        minDate: 0,
        onClose: function( selectedDate ){
            $( '#end-date' ).datepicker( 'option', 'minDate', selectedDate);
            $( '#end-date' ).datepicker('setDate', selectedDate);
            $( '#deadline' ).datepicker( 'option', 'maxDate', selectedDate);

        }
    });
    $( '#end-date' ).datepicker({
        dateFormat: 'dd MM, yy',
        onClose: function( selectedDate ){
            $( '#start-date' ).datepicker(  'option', 'maxDate', selectedDate);
        }
    });

    $( '#deadline' ).datepicker({
        dateFormat: 'dd MM, yy',
        minDate: 0,
        onClose: function( selectedDate ){
        }
    });


})( jQuery );
