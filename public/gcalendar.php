<?php
$content = file_get_contents('https://www.google.com/calendar/embed?src=tih8l4rg8u9vbttfqc1f9m7a38%40group.calendar.google.com&amp;ctz=America/Los_Angeles');

$upperhead = '<base href="https://www.google.com/calendar/" />';
$content = str_replace('</title>', '</title>' . $upperhead, $content);

$localjs = '<script type="text/javascript" src="700b264c85488efd07b9e06c07b828a4embedcompiled__en.js"></script>';
$originaljs = '<script src="https://www.google.com/calendar/static/700b264c85488efd07b9e06c07b828a4embedcompiled__en.js"></script>"';
$content = str_replace($localjs, $originaljs, $content);

$morehead = '<link rel="stylesheet" href="http://sf-eagle.com/storm/public/gcalendar.css" />';
//$morehead = '<script defer src="http://sf-eagle.com/storm/public/gcalendar.js"></script>"' . $morehead;
$content = str_replace('</head>', $morehead . '</head>', $content);


echo $content;
