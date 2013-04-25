<?php
include_once 'functions.php';
$hour = sanitizeString($_POST['hour']);
$day = sanitizeString($_POST['day']);
$month = sanitizeString($_POST['month']);
$year = sanitizeString($_POST['year']);
$subreddit = sanitizeString($_POST['subreddit']);
echo "<select name='subreddit' id='subreddit'>";
echo "<option value = 'all%'";
if($subreddit == 'all%')
    echo "selected='selected'";
echo ">All</option>";
echo "<option value = 'top%'";
if($subreddit == 'top%')
    echo "selected='selected'";
echo ">Default Top</option>";
$result = queryMysql("select sub, count(distinct sub) from toplinks where sub not like 'all%' and sub not like 'top%' and month = '$month' and day = '$day' and hour = '$hour' and year = '$year' group by sub");
$num = mysql_num_rows($result);
if($num > 0)
{
    for($i = 0; $i < $num; $i++)
    {
        $row = mysql_fetch_row($result);
        $j=$row[0];
        echo "<option value='$j'";
        echo ">$j</option>";
    }
}
else
{
    $hour=0;
    $result = queryMysql("select sub, count(distinct sub) from toplinks where sub not like 'all%' and sub not like 'top%' and month = '$month' and
        day = '$day' and hour = '$hour' and year = '$year' group by sub");
    $num = mysql_num_rows($result);
    for($i = 0; $i < $num; $i++)
    {
        $row = mysql_fetch_row($result);
        $j=$row[0];
        echo "<option value='$j'";
        echo ">$j</option>";
    }
}
echo "</select>";
?>