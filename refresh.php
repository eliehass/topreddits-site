<?php
include_once 'functions.php';

$theMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
$theHours = ['12 am', '1 am', '2 am', '3 am', '4 am', '5 am', '6 am', '7 am', '8 am', '9 am', '10 am', '11 am', '12 pm', '1 pm', '2 pm', 
'3 pm', '4 pm', '5 pm', '6 pm', '7 pm', '8 pm', '9 pm', '10 pm', '11 pm']; 

if(isset($_POST['month']))
{
    $hour = sanitizeString($_POST['hour']);
    $day = sanitizeString($_POST['day']);
    $month = sanitizeString($_POST['month']);
    $year = sanitizeString($_POST['year']);
    $subreddit = sanitizeString($_POST['subreddit']);
    if(isset($_POST['theinterval']))
        $theinterval = sanitizeString($_POST['theinterval']);
    
    $type = sanitizeString($_POST['type']);
    
echo "<div style='width: 1000px;'>";
echo "<div name='monthdiv' style='float: left; padding-left: 250px; width: 50px;'>";
echo "Month<br />";
echo "<select name='month' id='month' onChange='refreshData()'>";
$result = queryMysql("select month, count(distinct month) from toplinks where year=$year group by month");
$num = mysql_num_rows($result);
for($i = 0; $i < $num; $i++)
{
    $row = mysql_fetch_row($result);
    $j=$row[0];
    echo "<option value='$j'";
    if($month==$j)
        echo " selected='selected'";
    echo ">";
    echo "$theMonths[$j]</option>";
}
echo "</select>";
echo "</div>";
echo "<div name='daydiv' style='float: left; width: 50px; padding-left: 10px;'>";
echo "Day<br />";
echo "<select name='day' id='day' onChange='refreshData()'>";
$result = queryMysql("select day, count(distinct day) from toplinks where month=$month and year=$year group by day desc");
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
    if($day==$j)
        echo " selected='selected'";
    echo ">$j</option>";
}
echo "</select>";
echo "</div>";
echo "<div name='hourdiv' style='float: left; width: 50px; padding-left: 0px;'>";
echo "Hour<br />";
echo "<select name='hour' id='hour' onChange='refreshData()'>";
$result = queryMysql("select hour, count(distinct hour) from toplinks where month=$month and year=$year and day=$day group by hour");
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
    if($hour==$j)
        echo " selected='selected'";
    echo ">$theHours[$j]</option>";
}
echo "</select></div>";
echo "<div name='yeardiv' style='float: left; width: 50px; padding-left: 20px;'>";
echo "Year<br />";
echo "<select name='year' id='year' onChange='refreshData()'>";
$result = queryMysql("select year, count(distinct year) from toplinks");
$num = mysql_num_rows($result);
$row = mysql_fetch_row($result);
for($i = 0; $i < $num; $i++)
{
    $j=$row[0];
    echo "<option value='$j'";
    if($year==$j)
        echo " selected='selected'";
    echo ">$j</option>";
}
echo "</select></div>";
echo "<div name='subdiv' style='float: left; width: 50px; padding-left: 13px;'>";
echo "Subreddit<br />";
echo "<select name='subreddit' id='subreddit' onChange='refreshData()'>";
echo "<option value = 'all%'";
if($subreddit == 'all%')
    echo "selected='selected'";
echo ">All</option>";
echo "<option value = 'top%'";
if($subreddit == 'top%')
    echo "selected='selected'";
echo ">Default Top</option>";
$result = queryMysql("select sub, count(distinct sub) from toplinks where sub not like 'all%' and sub not like 'top%' and month = $month and day = $day and hour = $hour and year = $year group by sub");
$num = mysql_num_rows($result);
for($i = 0; $i < $num; $i++)
{
    $row = mysql_fetch_row($result);
    $j=$row[0];
    echo "<option value='$j'";
    if($subreddit==$j)
        echo " selected='selected'";
    echo ">$j</option>";
}
echo "</select></div>";
echo "<div name='typediv' style='float: left; width: 50px; padding-left: 70px;'>";
echo "Type<br />";
echo "<select name='type' id='type' onChange='refreshData()'>";
echo "<option value='hot'";
if($type=="hot")
    echo" selected='selected'";
echo ">hot</option>";
echo "<option value='top'";
if($type=="top")
    echo" selected='selected'";
echo ">top</option>" .
    "</select></div>";
if($type=="top")
{
    echo "<div name='intervaldiv' style='float: left; width: 50px; padding-left: 3px;'>";
    echo "Interval<br />";
    echo "<select name='theinterval' id='theinterval'>";
    echo "<option value='hourly'";
    if($theinterval == "hourly")
        echo " selected='selected'";
    echo ">Hourly</option>";
    echo "<option value='daily'";
    if($theinterval == "daily")
        echo " selected='selected'";
    echo ">Daily</option>";
    echo "<option value='weekly'";
    if($theinterval == "weekly")
        echo " selected='selected'";
    echo ">Weekly</option>";
    echo "<option value='monthly'";
    if($theinterval == "monthly")
        echo " selected='selected'";
    echo ">Monthly</option>";
    echo "<option value='yearly'";
    if($theinterval == "yearly")
        echo " selected='selected'";
    echo ">Yearly</option>";
    echo "<option value='all time'";
    if($theinterval == "all time")
        echo " selected='selected'";
    echo ">All Time</option>";
    echo "</select></div>";
}
if($type=="top")
{
echo<<<_END
<div name='submitdiv' style='float: left; width: 50px; padding-left: 25px;'><br />
<input type='submit' name='Go!' value='Go!' />
_END;
}
else
{
echo<<<_END
<div name='submitdiv' style='float: left; width: 50px; padding-left: 0px;'><br />
<input type='submit' name='Go!' value='Go!' />
_END;
}
}
?>