<?php
  require_once('../../../wp-blog-header.php');

  $eventID = intval($_GET["eventid"]);

  $query_start_date= get_post_field( 'event-start-date', $eventID );
  $query_end_date= get_post_field( 'event-end-date', $eventID );


  $start_day=get_date_from_gmt( date( 'Y-m-d H:i:s',$query_start_date ), 'j' );
  $start_month=get_date_from_gmt( date( 'Y-m-d H:i:s', $query_start_date ), 'M' );
  $start_month_full=get_date_from_gmt( date( 'Y-m-d H:i:s', $query_start_date ), 'F' );
  $end_day=get_date_from_gmt( date( 'Y-m-d H:i:s',$query_end_date), 'j' );
  $end_month=get_date_from_gmt( date( 'Y-m-d H:i:s', $query_end_date ), 'M' );
  $end_month_full=get_date_from_gmt( date( 'Y-m-d H:i:s', $query_end_date ), 'F' );


  header("Content-type: text/plain");
  header("Content-Disposition: attachment; filename=savethis.txt");

  // do your Db stuff here to get the content into $content
  print "Start: ".$start_day." ".$start_month;
  print "End: ".$end_day." ".$end_month;

?>
