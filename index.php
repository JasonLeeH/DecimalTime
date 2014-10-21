<?php
session_start();
$timezone = $_SESSION['time'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Revolutionary Time</title>
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<link href='http://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div id="centered">
        <div id="time"></div>
        <div id="location">
<?php
include ('city.php');
?>
</div>
    </div>
<script type="text/javascript">
function reload(){
    $("#time").load("revtime.php");
};
reload()
setInterval(reload, 5000);
</script>
<script type="text/javascript">
    $(document).ready(function() {
        if("<?php echo $timezone;?>".length==0){
            var visitortime = new Date();
            var visitortimezone = "GMT " + -visitortime.getTimezoneOffset()/60;
            $.ajax({
                type: "GET",
                url: "http://jason.sx/clock/timezone.php",
                data: 'time='+ visitortimezone,
                success: function(){
                    location.reload();
                }
            });
        }
    });
</script>
</body>
</html>