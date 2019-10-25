<?php

include("printers.php");
include("functions.php");




// Printers
$camera_count=0;
$display_printers="
	<table class=display border=0>";
foreach ($printers as $printer) {
	$name=$printer['name'];
	$short_name=$printer['short_name'];
	$external_web_cam_url=$printer['external_web_cam_url'];
	$internal_web_cam_url=$printer['internal_web_cam_url'];
	$web_cam_urls=$printer['web_cam_urls'];
	$printer_ip=$printer['printer_ip'];
	$api_key=$printer['api_key'];
        $image_class=$printer['image_class'];
        if (!$image_class) { $image_class="cam"; }
	$printer_info=CallAPI("GET","http://$printer_ip/api/printer?apikey=$api_key");
	if ( isJson($printer_info) == "1") {
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
		$printer_down_display="<table class=camsdown><tr><td>Octoprint is Not Connected</td></table>";
	}
	if ($camera_count >= "4") { $display_printers .="</table><table class=display>"; $camera_count=0; }
	$display_printers .="
		<td valign=top><table><td>
		<table class=printer>
		<tr><th><a href='http://$printer_ip' target='_blank'>$name</a></th></tr>";

	$display_printers .="<tr><td align=center>";
	foreach ($web_cam_urls as $web_cam_url) { $display_printers .="<img class='$image_class' src='$web_cam_url/?action=stream'>"; $camera_count++; }
	$display_printers .="</td>
		<tr><td><span id=$short_name>$printer_down_display</span></td>
		</table></td></table></td>";
}
?>

<html>
	<head>
	<title>Multi-Octoprint</title>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
        <link rel="stylesheet" type="text/css" href="main.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>
	</head>
	<body>
        <?php echo "$poll_printer"; ?>
	<?php echo "$display_printers"; ?>
	</table>
	</body>
</html>

