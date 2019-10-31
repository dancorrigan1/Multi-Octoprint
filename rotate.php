<?php
include("functions.php");
include("printers.php");
$total_cams=count($printers)-1;
$current_camera_file="camera.txt";
$current_camera = file_get_contents($current_camera_file);
if ($current_camera == $total_cams) {
	$new_camera = "0";
} else {
	$new_camera=$current_camera + 1;
}
file_put_contents($current_camera_file, $new_camera);

$printer=$current_camera;
$web_cam_urls=$printers[$printer][web_cam_urls];
$image_class=$printers[$printer][image_class];
$printer_name=$printers[$printer][name];
if (!$image_class) { $image_class="cam"; }
$image_class="big-".$image_class;
echo "<table class=rotate>";
foreach ($web_cam_urls as $web_cam_url) {
	echo "<td>$printer_name<br><img class='$image_class' src='$web_cam_url'></td>";
}
echo "</table>";
?>
