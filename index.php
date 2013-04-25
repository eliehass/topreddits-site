<?php
session_start();
date_default_timezone_set('America/New_York');
include 'functions.php';
$hour=$day=$month=$month=$year=$subreddit=$theinterval=$type="";
$theMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
$theHours = ['12 am', '1 am', '2 am', '3 am', '4 am', '5 am', '6 am', '7 am', '8 am', '9 am', '10 am', '11 am', '12 pm', '1 pm', '2 pm', 
'3 pm', '4 pm', '5 pm', '6 pm', '7 pm', '8 pm', '9 pm', '10 pm', '11 pm']; 

if(isset($_POST['hour']))
{
    $hour = sanitizeString($_POST['hour']);
    $day = sanitizeString($_POST['day']);
    $month = sanitizeString($_POST['month']);
    $year = sanitizeString($_POST['year']);
    $subreddit = sanitizeString($_POST['subreddit']);
    if(isset($_POST['theinterval']))
        $theinterval = sanitizeString($_POST['theinterval']);
    $type = sanitizeString($_POST['type']);
}
else
{
    $hour=date('G');
    $day=date('j');
    $month=date('n');
    $month--;
    $year=date('Y');
    $subreddit="top%";
    $theinterval="";
    $type="hot";
}

echo<<<_END
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<script src='OSC.js'></script>
<title>TopReddits</title>
</head>

<body>
<script>
function refreshDay()
{
    var theMonth = O('month').options[O('month').selectedIndex].value;
    var theYear = O('year').options[O('year').selectedIndex].value;  
       
    params = "month=" + theMonth + "&year=" + theYear
    request = new ajaxRequest()
    request.open("POST", "refreshDay.php", true) 
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded") 

    request.onreadystatechange = function() 
    {
        if (this.readyState == 4) 
            if (this.status == 200)
                if (this.responseText != null) 
                    O('refreshDay').innerHTML = this.responseText
    }
    request.send(params)     
}

function refreshHour()
{
    var theMonth = O('month').options[O('month').selectedIndex].value;
    var theYear = O('year').options[O('year').selectedIndex].value;
    var theDay = O('day').options[O('day').selectedIndex].value;  
    var theHour = O('hour').options[O('hour').selectedIndex].value;
       
    params = "month=" + theMonth + "&year=" + theYear + "&day=" + theDay + "&hour=" + theHour
    request = new ajaxRequest()
    request.open("POST", "refreshHour.php", true) 
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded") 

    request.onreadystatechange = function() 
    {
        if (this.readyState == 4) 
            if (this.status == 200)
                if (this.responseText != null) 
                    O('refreshHour').innerHTML = this.responseText
    }
    request.send(params)     
}

function refreshSub()
{
    var theMonth = O('month').options[O('month').selectedIndex].value;
    var theYear = O('year').options[O('year').selectedIndex].value;
    var theDay = O('day').options[O('day').selectedIndex].value;
    var theHour = O('hour').options[O('hour').selectedIndex].value; 
    var theSubreddit = O('subreddit').options[O('subreddit').selectedIndex].value; 
       
    params = "month=" + theMonth + "&year=" + theYear + "&day=" + theDay + "&hour=" + theHour + "&subreddit=" + theSubreddit
    request = new ajaxRequest()
    request.open("POST", "refreshSubreddit.php", true) 
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded") 

    request.onreadystatechange = function() 
    {
        if (this.readyState == 4) 
            if (this.status == 200)
                if (this.responseText != null) 
                    O('refreshSubreddit').innerHTML = this.responseText
    }
    request.send(params)     
}

function refreshMonth()
{
    var theMonth = O('month').options[O('month').selectedIndex].value;
    var theYear = O('year').options[O('year').selectedIndex].value; 
       
    params = "month=" + theMonth + "&year=" + theYear
    request = new ajaxRequest()
    request.open("POST", "refreshMonth.php", true) 
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded") 

    request.onreadystatechange = function() 
    {
        if (this.readyState == 4) 
            if (this.status == 200)
                if (this.responseText != null) 
                    O('refreshMonth').innerHTML = this.responseText
    }
    request.send(params)     
}

function refreshType()
{
    var theType = O('type').options[O('type').selectedIndex].value;
    if (theType == "top")
    {
        if('$theinterval' != "")
            var theInterval = O('theinterval').options[O('theinterval').selectedIndex].value;  
    }
       
    params = "type=" + theType
    if('$theinterval' != "")
        params += "&interval=" + theInterval
    request = new ajaxRequest()
    request.open("POST", "refreshType.php", true) 
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded") 

    request.onreadystatechange = function() 
    {
        if (this.readyState == 4) 
            if (this.status == 200)
                if (this.responseText != null) 
                    O('refreshType').innerHTML = this.responseText
    }
    request.send(params)     
}

function ajaxRequest() 
{
    try { var request = new XMLHttpRequest() } 
    catch(e1) {
        try { request = new ActiveXObject("Msxml2.XMLHTTP") } 
        catch(e2) {
            try { request = new ActiveXObject("Microsoft.XMLHTTP") } 
            catch(e3) {
                request = false
    }  }  }
    return request 
}
</script>
<div name='titlediv' style='padding-left: 380px;'>
<h1 style="color:#3D60B1">Top Reddits</h1>
</div>
<form id='select' action='index.php' method='post' align='center'>
_END;
echo "<div style='width: 1000px;'>";
echo "<div name='monthdiv' style='float: left; padding-left: 250px;'>";
echo "Month<br />";
echo "<span id='refreshMonth'>";
echo "<select name='month' id='month' onChange='refreshDay(); refreshHour(); refreshSub();'>";
$result = queryMysql("select month, count(distinct month) from toplinks where year='$year' group by month");
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
echo "</span>";
echo "</div>";
echo "<div name='daydiv' style='float: left; padding-left: 0px;'>";
echo "Day<br />";
echo "<span ='refreshDay'>";
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
    if($day==$j)
        echo " selected='selected'";
    echo ">$j</option>";
}
echo "</select>";
echo "</span>";
echo "</div>";
echo "<div name='hourdiv' style='float: left; padding-left: 0px;'>";
echo "Hour<br />";
echo "<span id='refreshHour'>";
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
    if($hour==$j)
        echo " selected='selected'";
    echo ">$theHours[$j]</option>";
}
echo "</select></span></div>";
echo "<div name='yeardiv' style='float: left; padding-left: 0px;'>";
echo "Year<br />";
echo "<select name='year' id='year' onChange='refreshDay(); refreshHour(); refreshSub(); refreshMonth();'>";
$result = queryMysql("select year, count(distinct year) from toplinks group by year");
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
echo "<div name='subdiv' style='float: left; padding-left: 0px;'>";
echo "Subreddit<br />";
echo "<span id='refreshSubreddit'>";
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
for($i = 0; $i < $num; $i++)
{
    $row = mysql_fetch_row($result);
    $j=$row[0];
    echo "<option value='$j'";
    if($subreddit==$j)
        echo " selected='selected'";
    echo ">$j</option>";
}
echo "</select></span></div>";
echo "<span id='refreshType'>";
echo "<div name='typediv' style='float: left; padding-left: 0px;'>";
echo "Type<br />";
echo "<select name='type' id='type' onChange='refreshType()'>";
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
    echo "<div name='intervaldiv' style='float: left; padding-left: 0px;'>";
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
<div name='submitdiv' style='float: left; padding-left: 0px;'><br />
<input type='submit' name='Go!' value='Go!' />
</div>
_END;
}
else
{
echo<<<_END
<div name='submitdiv' style='float: left; padding-left: 0px;'><br />
<input type='submit' name='Go!' value='Go!' />
</div>
_END;
}
echo<<<_END
</span>

</form><br /><br />
<br />
<br />
<br />
<br />
<div name='subs' style='float: left;' align='left'>
_END;

$num=1;
$result = queryMysql("select title, link, comments, sub from toplinks where hour='$hour' and 
day='$day' and month='$month' and year='$year' and sub like '$subreddit' and theinterval='$theinterval' 
and type='$type'");
$num = mysql_num_rows($result);
if(isset($_POST['Go!']) && $num == 0)
    echo "Sorry there are no results. Try another search.";
if(isset($_POST['Go!']) && $num != 0)
{
    $all = "all-";
    $top = "top-";
    for($i = 1; $i <= $num; $i++)
    {
        $row = mysql_fetch_row($result);
        $thelink=$row[1];
        //if the post is a self post, we need to add the reddit domain
        if(!strpos($thelink,'.'))
            $thelink = 'http://reddit.com' . $thelink;
        $thetitle=$row[0];
        $thecomments=$row[2];
        $thesub=$row[3];
        $thesub = str_replace("all-", "", $thesub);
        $thesub = str_replace("top-", "", $thesub);
        echo "$i.&nbsp&nbsp<a href='$thelink'>$thetitle</a>----" .
            "<a href='$thecomments'>comments</a>----$thesub<br /><br />";
    }
    
    //link to the next hour if there is one
    $nexthour = $hour;
    $nextday = $day;
    $nextmonth = $month;
    $nextyear = $year;
    $numberofdays = count($dayarray);
    if($hour < 23)
    {
        $nexthour = $hour + 1;
        $nextDay = $day;
    }
    else if($hour == 23 && $day != $dayarray[$numberofdays-1])
    {
        $nexthour = 0;
        $nextday = $day+1;
    }
    else if($hour == 23 && $day == $dayarray[$numberofdays-1] && $month < 11)
    {
        $nexthour = 0;
        $nextday = 1;
        $nextmonth = $month + 1;
    }
        else if($hour == 23 && $day == $dayarray[$numberofdays-1] && $month == 11)
    {
        $nexthour = 0;
        $nextday = 1;
        $nextmonth = 0;
        $nextyear = $year + 1;
    }
    $result = queryMysql("select title, link, comments, sub from toplinks where hour='$nexthour' and 
        day='$nextday' and month='$nextmonth' and year='$nextyear' and sub like '$subreddit' and theinterval='$theinterval' 
        and type='$type'");
    $num = mysql_num_rows($result);
    if($num > 0)
    {
        echo "<form id='next' action='index.php' method='post' style='float: right;'>" .
            "<input name='month' value='$nextmonth' style='visibility:hidden;'></input>" .
            "<input name='day' value='$nextday' style='visibility:hidden;'></input>" .
            "<input name='hour' value='$nexthour' style='visibility:hidden;'></input>" .
            "<input name='year' value='$nextyear' style='visibility:hidden;'></input>" .
            "<input name='subreddit' value='$subreddit' style='visibility:hidden;'></input>" .
            "<input name='type' value='$type' style='visibility:hidden;'></input>";
        if($theinterval != "")
            echo "<input name='theinterval' value='$interval' style='visibility:hidden;'></input>";
        echo "<input type='submit' name='Go!' value='next' /></form>";
    }
}
echo <<<_END
</div>
</body>
</html>
_END;
?>