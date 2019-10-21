<?php

include("printers.php");

function secondsToTime($inputSeconds) {

    $secondsInAMinute = 60;
    $secondsInAnHour  = 60 * $secondsInAMinute;
    $secondsInADay    = 24 * $secondsInAnHour;

    // extract days
    $days = floor($inputSeconds / $secondsInADay);

    // extract hours
    $hourSeconds = $inputSeconds % $secondsInADay;
    $hours = floor($hourSeconds / $secondsInAnHour);

    // extract minutes
    $minuteSeconds = $hourSeconds % $secondsInAnHour;
    $minutes = floor($minuteSeconds / $secondsInAMinute);

    // extract the remaining seconds
    $remainingSeconds = $minuteSeconds % $secondsInAMinute;
    $seconds = ceil($remainingSeconds);

    // return the final array
    $obj = array(
        'd' => (int) $days,
        'h' => (int) $hours,
        'm' => (int) $minutes,
        's' => (int) $seconds,
    );
    return $obj;
}

function CallAPI($method, $url, $data = false) {
	$curl = curl_init();
	switch ($method) {
		case "POST":
			curl_setopt($curl, CURLOPT_POST, 1);

		if ($data)
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		break;
		case "PUT":
			curl_setopt($curl, CURLOPT_PUT, 1);
		break;
		default:
		if ($data)
			$url = sprintf("%s?%s", $url, http_build_query($data));
	}
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($curl);
	curl_close($curl);
	return $result;
}

$printer_count=0;


// Printers
foreach ($printers as $printer) {
	$name=$printer['name'];
	$short_name=$printer['short_name'];
	$external_web_cam_url=$printer['external_web_cam_url'];
	$printer_ip=$printer['printer_ip'];
	$api_key=$printer['api_key'];
	$printer_info=CallAPI("GET","http://$printer_ip/api/printer?apikey=$api_key");
	if ($printer_info != "Printer is not operational") {
		$printer_status="Up";
		$poll_printer .="<script>
		$(document).ready(function() {
		    setInterval($short_name, 1000);
		});

		function $short_name() {
		    $.ajax({
		        url: 'stats.php?short_name=$short_name',
		        success: function(data) {
		            $('#$short_name').html(data);
		        },
		    });
		}
		</script>";
	} else {
		$printer_down_display="<table class=camsdown><tr><td class=labelspan>Octoprint is Not Connected</td></table>";
	}


	if ($printer_count == "2") { $display_printers .="<tr>"; $printer_count=0; }
	$display_printers .="<td align=center valign=top class=cam>
		<table class=cams>
		<th colspan=2 class=head>$name</th>
		<tr><td><img class=cam src='$web_cam_url/?action=stream'></td>
		</table>
		<span id=$short_name>$printer_down_display</span>
		</td>";
	$printer_count++;
}
?>

<html>
	<head>
	<title>Printer Cams</title>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
        <link rel="stylesheet" type="text/css" href="main.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>
	</head>
	<body>
        <?php echo "$poll_printer"; ?>
	<table align=center>
	<?php echo "$display_printers"; ?>
	</table>
	</body>
</html>

