<?php
    date_default_timezone_set('America/Los_Angeles');
    $now = time();
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
?>
