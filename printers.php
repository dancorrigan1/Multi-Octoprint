<?php
$printers = array(
	array(
		"name" => "Prusa 1",
		"short_name" => "prusa1",
		"printer_ip" => "192.168.1.101",
		"api_key" => "abc123",
		"web_cam_urls" => array("http://192.168.1.101:8080/?action=stream"),
	),
	array(
		"name" => "Prusa 2",
		"short_name" => "prusa2",
		"printer_ip" => "192.168.1.124",
		"api_key" => "abc123",
		"web_cam_urls" => array("http://192.168.1.124:8080/?action=stream"),
	),
	array(
		"name" => "Prusa 3",
		"short_name" => "prusa3",
		"printer_ip" => "192.168.1.65",
		"api_key" => "abc123",
		"web_cam_urls" => array("http://192.168.1.65:8080/?action=stream","http://192.168.1.65:8081/?action=stream"),
		"image_class" => "rotate180",
	),
	array(
		"name" => "Sir-10",
		"short_name" => "sir10",
		"printer_ip" => "192.168.1.66",
		"api_key" => "abc123",
		"web_cam_urls" => array("http://192.168.1.66:8080/?action=stream"),
	),
	array(
		"name" => "300 Super+",
		"short_name" => "super300",
		"printer_ip" => "192.168.1.71",
		"api_key" => "abc123",
		"web_cam_urls" => array("http://192.168.1.71:8080/?action=stream"),
	),
	array(
		"name" => "Ultimaker",
		"short_name" => "ultimaker",
		"printer_ip" => "192.168.1.103",
		"api_key" => "abc123",
		"web_cam_urls" => array("http://192.168.1.103:8080/?action=stream"),
	),

	array(
		"name" => "Printer Enclosures",
		"short_name" => "enclosures1",
		"printer_ip" => "",
		"api_key" => "",
		"web_cam_urls" => array("http://192.168.7.109:8080"),
	),
);

?>
