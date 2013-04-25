<?php
include_once 'functions.php';
$theMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

$month = sanitizeString($_POST['month']);
$year = sanitizeString($_POST['year']);

echo "<select name='month' id='month' onChange='refreshDay(); refreshHour(); refreshSub();'>";
$result = queryMysql("select month, count(distinct month) from toplinks where year='$year' group by month");
$num = mysql_num_rows($result);
for($i = 0; $i < $num; $i++)
{
    $row = mysql_fetch_row($result);
    $j=$row[0];
    echo "<option value='$j'";
    echo ">";
    echo "$theMonths[$j]</option>";
}
echo "</select>";
?>