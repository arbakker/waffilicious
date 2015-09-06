<?php
  require_once('../../../wp-blog-header.php');
date_default_timezone_set('Europe/Amsterdam');
  function dateToCal($timestamp) {
  return date('Ymd\THis', $timestamp);
}
function alldaydateToCal($timestamp) {
return date('Ymd', $timestamp);
}

$start_time=  date( 'H:i',$query_start_date );
$end_time=  date( 'H:i',$query_end_date );
$start_day=  date( 'Y-m-d',$query_start_date );
$end_day=  date( 'Y-m-d',$query_end_date );

$allday=False;
$oneday=False;
if ($start_time==$end_time){
  $allday=True;
  if($start_day!==$end_day){
    $oneday=True;
}
}

  $eventID = intval($_GET["eventid"]);

  $query_start_date= get_post_field( 'event-start-date', $eventID );
  $query_end_date= get_post_field( 'event-end-date', $eventID );

  $content =  wp_strip_all_tags(get_post_field('post_content', $eventID));
  $title =  get_the_title( $eventID);

  header("Content-type: text/plain");
  header("Content-Disposition: attachment; filename='".$title.".ics'");

  /*
  BEGIN:VCALENDAR
  VERSION:2.0
  PRODID:-//hacksw/handcal//NONSGML v1.0//EN
  BEGIN:VEVENT
  UID:uid1@example.com
  DTSTAMP:19970714T170000Z
  ORGANIZER;CN=John Doe:MAILTO:john.doe@example.com
  DTSTART:19970714T170000Z
  DTEND:19970715T035959Z
  SUMMARY:Bastille Day Party
  END:VEVENT
  END:VCALENDAR
  */


  $eol = "\r\n";
  // do your Db stuff here to get the content into $content
  print "BEGIN:VCALENDAR".$eol ;
  print "VERSION:2.0".$eol ;
  print "PRODID:-//WAF/WAF Website//EN".$eol ;
  print "BEGIN:VEVENT".$eol ;
  print "SUMMARY: ". $title.$eol  ;
  print "UID:".(string)$eventID.$eol ;

  if ($allday){
    if ($oneday){
    print "DTSTART;VALUE=DATE:".alldaydateToCal($query_start_date).$eol ;
  }else{
    print "DTSTART:".alldaydateToCal($query_start_date)."T000000".$eol ;
    print "DTEND:".alldaydateToCal(strtotime('+1 day', $query_end_date))."T000000".$eol ;
  }
  }else{
    print "DTSTART:".dateToCal($query_start_date).$eol ;
    print "DTEND:".dateToCal($query_end_date).$eol ;
  }


  print "END:VEVENT".$eol ;
  print "END:VCALENDAR".$eol ;
?>
