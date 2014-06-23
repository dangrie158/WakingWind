<?php
if (isset($_GET["regId"]) && isset($_GET["message"]) && isset($_GET["msgcnt"])) {
    $regId = $_GET["regId"];
    $message = $_GET["message"];
	$msgcnt = $_GET["msgcnt"];
	$soundname = 'bell.mp3';
     
    include_once './GCM.php';
     
    $gcm = new GCM();
 
    $registatoin_ids = array($regId);
    $message = array("message" => $message, "msgcnt" => $msgcnt, "soundname" => $soundname);
 
    $result = $gcm->send_notification($registatoin_ids, $message);
 
    echo $result;
}
?>