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
/**
 * Helps with timezones.
 * @link http://us.php.net/manual/en/class.datetimezone.php
 *
 * @package  Date
 */
class Helper_DateTimeZone extends DateTimeZone {
	/**
	 * Converts a timezone hourly offset to its timezone's name.
	 * @example $offset = -5, $isDst = 0 <=> return value = 'America/New_York'
	 *
	 * @param float $offset The timezone's offset in hours.
	 *                      Lowest value: -12 (Pacific/Kwajalein)
	 *                      Highest value: 14 (Pacific/Kiritimati)
	 * @param bool  $isDst  Is the offset for the timezone when it's in daylight
	 *                      savings time?
	 *
	 * @return string The name of the timezone: 'Asia/Tokyo', 'Europe/Paris', ...
	 */
	final public static function tzOffsetToName($offset, $isDst = null) {
		if ($isDst === null) {
			$isDst = date('I');
		}

		$offset *= 3600;
		$zone = timezone_name_from_abbr('', $offset, $isDst);

		if ($zone === false) {
			foreach (timezone_abbreviations_list() as $abbr) {
				foreach ($abbr as $city) {
					if ((bool) $city['dst'] === (bool) $isDst &&
						strlen($city['timezone_id']) > 0 &&
						$city['offset'] == $offset) {
						$zone = $city['timezone_id'];
						break;
					}
				}

				if ($zone !== false) {
					break;
				}
			}
		}

		return $zone;
	}
}
$tmz = substr($timezone, 4);
$Dtz = new Helper_DateTimeZone(Helper_DateTimeZone::tzOffsetToName($tmz));
ob_start();
var_dump($Dtz->getName());
$region = ob_get_clean();
$region = str_replace('"', '', substr($region, strpos($region, '"') + 1));
$region_fixed = str_replace('_', ' ', substr($region, strpos($region, '/') + 1));
echo $region_fixed;
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