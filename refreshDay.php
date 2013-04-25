<?php
include_once 'functions.php';
$month = sanitizeString($_POST['month']);
$year = sanitizeString($_POST['year']);
echo "<select name='day' id='day' onChange='refreshHour(); refreshSub();'>";
$result = queryMysql("select day, count(distinct day) from toplinks where month='$month' and year='$year' group by day desc");
$num = mysql_num_rows($result);
$dayarray = array();
for($i = 0; $i < $num; $i++)
{
    $row = mysql_fetch_row($result);
    $dayarray[] = $row[0]; 
}
sort($dayarray, SORT_NUMERIC);
for($i = 0; $i < $num; $i++)
{
    $j = $dayarray[$i]; 
    echo "<option value='$j'";
    echo ">$j</option>";
}
?>