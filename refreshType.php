<?php
include_once 'functions.php';

$theinterval = "";
if(isset($_POST['theinterval']))
    $theinterval = sanitizeString($_POST['theinterval']);
$type = sanitizeString($_POST['type']);


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
?>