<?php

include("printers.php");
$short_name=$_GET['short_name'];
$printer_search=array_search("$short_name", array_column($printers, 'short_name'));
$printer_ip=$printers[$printer_search][printer_ip];
$api_key=$printers[$printer_search][api_key];


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


// Printer Info
$printer_info=CallAPI("GET","http://$printer_ip/api/printer?apikey=$api_key");
$printer_info_response = json_decode($printer_info, true);
$hotend_temp_actual=$printer_info_response['temperature']['tool0']['actual'];
$hotend_temp_target=$printer_info_response['temperature']['tool0']['target'];
$bed_temp_actual=$printer_info_response['temperature']['bed']['actual'];
$bed_temp_target=$printer_info_response['temperature']['bed']['target'];

// Job Stats
$job_info=CallAPI("GET","http://$printer_ip/api/job?apikey=$api_key");
$job_info_response = json_decode($job_info, true);
$job_info_completion=round($job_info_response['progress']['completion']);
$get_job_info_printtime=secondsToTime($job_info_response['progress']['printTime']);
$get_job_info_printtimeleft=secondsToTime($job_info_response['progress']['printTimeLeft']);
$job_info_printtime="$get_job_info_printtime[d] Days, $get_job_info_printtime[h] Hours, $get_job_info_printtime[m] Minutes, $get_job_info_printtime[s] Seconds"; 
$job_info_printtimeleft="$get_job_info_printtimeleft[d] Days, $get_job_info_printtimeleft[h] Hours, $get_job_info_printtimeleft[m] Minutes, $get_job_info_printtimeleft[s] Seconds"; 
$job_info_display=$job_info_response['job']['file']['display'];

echo "<table class=stats>
<tr><td class=label>Job Name</td><td class=info>$job_info_display</td>
<tr><td class=label>% Complete</td><td class=info>$job_info_completion%</td>
<tr><td class=label>Elapsed</td><td class=info>$job_info_printtime</td>
<tr><td class=label>Remaining</td><td class=info>$job_info_printtimeleft</td>
<tr><td class=label>Hotend</td><td class=info>A:$hotend_temp_actual T:$hotend_temp_target</td>
<tr><td class=label>Heatbed</td><td class=info>A:$bed_temp_actual T:$bed_temp_target</td></table>";
