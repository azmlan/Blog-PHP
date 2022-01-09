<?php
date_default_timezone_set("Asia/Riyadh");
$currentTiem = time();
// $dateTime = strftime("%Y-%m-%d %H:%M:%S", $currentTiem);
$dateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTiem);
// $dateTime = strftime("%B-%d-%Y", $currentTiem);
echo $dateTime;
