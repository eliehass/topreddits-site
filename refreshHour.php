<?php
include_once 'functions.php';
$day = sanitizeString($_POST['day']);
$month = sanitizeString($_POST['month']);
$year = sanitizeString($_POST['year']);
$hour = sanitizeString($_POST['hour']);
$theHours = ['12 am', '1 am', '2 am', '3 am', '4 am', '5 am', '6 am', '7 am', '8 am', '9 am', '10 am', '11 am', '12 pm', '1 pm', '2 pm', 
'3 pm', '4 pm', '5 pm', '6 pm', '7 pm', '8 pm', '9 pm', '10 pm', '11 pm']; 
echo "<select name='hour' id='hour' onChange='refreshSub()'>";
$result = queryMysql("select hour, count(distinct hour) from toplinks where month='$month' and year='$year' and day='$day' group by hour");
$num = mysql_num_rows($result);
$timearray = array();
for($i = 0; $i < $num; $i++)
{
    $row = mysql_fetch_row($result);
    $timearray[] = $row[0]; 
}
sort($timearray, SORT_NUMERIC);
for($i = 0; $i < $num; $i++)
{
    $j = $timearray[$i]; 
    echo "<option value='$j'";
    echo ">$theHours[$j]</option>";
}
echo "</select>";
?>