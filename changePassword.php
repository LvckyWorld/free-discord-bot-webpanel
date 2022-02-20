<?php
session_name("lw-session");
session_start();

$json = file_get_contents("./config.json");
$data = json_decode($json);

$url = $data->serverIP;
$port = $data->port;
$verifyHeader = $data->verifyHeader;

$username = $_SESSION['username'];
$passwordSession = $_SESSION['password'];
if (empty($username) || empty($passwordSession)) {
    header("HTTP/1.1 403 Forbidden");
    exit;
} else {
    $json = file_get_contents("http://".$url.":".$port."/admins");
    $data = json_decode($json);
    
    for ($i = 0; $i<count($data); $i++) {
        $name = $data[$i]->name;
        $password =  $data[$i]->password;
        if ($username == $name && $passwordSession == $password) {
            
            $discorid = $data[$i]->discordID;
            $newpassword = $_POST['password'];
            $postdata = http_build_query(
                array(
                    'newpassword' => $newpassword,
                    'discordid' => $discorid
                )
            );
            $opts = array('http' =>
                array(
                    'method' => 'POST',
                    'header' => array(
                        'Content-type: application/x-www-form-urlencoded',
                        'verify: ' . $verifyHeader
                    ),
                    'content' => $postdata
                )
            );
            $context = stream_context_create($opts);
            $result = file_get_contents("http://".$url.":".$port."/changepw", false, $context);
            header('Location: ./index.php');
            
        } else {
        }
    }
}
?>