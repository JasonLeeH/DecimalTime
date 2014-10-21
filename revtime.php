<?php
date_default_timezone_set($timezone);
$ss = time() - strtotime("today");
$dh = $ss / 8640;
$dt = explode(".", $dh);
$dm = substr($dt[1], 0, 2);
$dm = str_pad($dm, 2, '0', STR_PAD_RIGHT);
echo $dt[0] . ':' . $dm . "\n\n";
?>