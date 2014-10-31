jQuery().ready(function() {



    jQuery( '#start-date' ).datepicker({
        dateFormat: 'dd MM yy',
        minDate: 0,
        onClose: function( selectedDate ){
            $( '#end-date' ).datepicker( 'option', 'minDate', selectedDate);
            $( '#end-date' ).datepicker('setDate', selectedDate);
            $( '#deadline' ).datepicker( 'option', 'maxDate', selectedDate);

        }
    });
    jQuery( '#end-date' ).datepicker({
        dateFormat: 'dd MM yy',
        onClose: function( selectedDate ){
            $( '#start-date' ).datepicker(  'option', 'maxDate', selectedDate);
        }
    });

    jQuery( '#deadline' ).datepicker({
        dateFormat: 'dd MM yy',
        minDate: 0,
        onClose: function( selectedDate ){
        }
    });


    jQuery(".chosen").chosen();



    jQuery("#add-members").click(function() {
    var id = jQuery("#add-members").attr('postid');
    var members=jQuery("#select-members").val();
    var members_string ="";
    members.forEach(function(entry){
      members_string+=entry+",";
    });

    jQuery.ajax({
           type: "POST",
           url: ajaxurl,
           data: "action=addmembers&id="+id+"&members="+members_string,
           success: function(data){
                  console.log("bla");
           }
         });
    });

    function test() {
    var members=jQuery("#select-members").val();
    var members_string ="";
    members.forEach(function(entry){
      members_string+=entry+",";
    });

    jQuery.ajax({
           type: "POST",
           url: ajaxurl,
           data: "action=addmembers&id="+id+"&members="+members_string,
           success: function(data){
                  console.log("bla");
           }
         });
    }

});
