<?php
include("printers.php");
include("functions.php");
//include("main.php");
?>

<html>
	<head>
        <title>Multi-Octoprint</title>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
        <link rel="stylesheet" type="text/css" href="main.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>
        <meta http-equiv=refresh content=300>
        </head>
        <body>
	<p class=head align=center><a href='?'>Detailed View</a> - <a href ='?rotate=1'>Rotating</a></p>
        <?php
	if (!$_GET[rotate]) {
	        include("main.php");
	} else {
		include("rotatecams.php");
	}
	?>
        </table>
        </body>
</html>
