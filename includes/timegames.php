<?php
    date_default_timezone_set('America/Los_Angeles');
    $now = time();
    $week_from_now = $now + 60*60*24*7;
    $this_day = date( 'j', $now);
    $this_month = date( 'n', $now);
    $this_year = date( 'y', $now);
    $date = get_post_meta(get_the_ID(), 'date', true);
    $start = get_post_meta(get_the_ID(), 'time', true);
    $finish = get_post_meta(get_the_ID(), 'endtime', true);
    $endtime_guess = strtotime($date . " " . $finish);
    $begintime = strtotime($date . " " . $start);
    if ( $endtime_guess < $begintime )
    {
    $date_epoch = strtotime($date);
    $date_plus_one = date ('y-n-j', strtotime('+1 day', $date_epoch));
    $endtime = strtotime($date_plus_one . " " . $finish);
    }
    else
    {
    $endtime = strtotime($date . " " . $finish);
    }
    $timeuntil = $now - $begintime;
    $timeuntilend = $now - $endtime;
    $publish_time = strtotime($post->post_date);
    $timeuntilpublish = $now - $publish_time;
?>
