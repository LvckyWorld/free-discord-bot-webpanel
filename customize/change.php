<!-- apply changes from index -->
<!-- You have to do this: 
     - add the functions
     - if avatarurl == null/undefined && username == null/undefined -> return error
     - if avatarurl == null/undefined but username has a value -> update username
     - if username == null/undefined but avatarurl has a value -> update avatarurl
     - if both have a value -> update both
-->

<?php
session_name("lw-session");
session_start();

$json = file_get_contents("../config.json");
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
     $json = file_get_contents("http://" . $url . ":" . $port . "/admins");
     $data = json_decode($json);

     for ($i = 0; $i < count($data); $i++) {
          $name = $data[$i]->name;
          $password =  $data[$i]->password;
          if ($username == $name && $passwordSession == $password) {
               $newUsername = $_POST['newUsername'];
               $avatarurl = $_POST['avatarurl'];

               if (!(empty($newUsername))) {
                    $postdata = http_build_query(
                         array(
                              'action' => "changeusername",
                              'name' => $newUsername
                         )
                    );
                    $opts = array(
                         'http' =>
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
                    $result = file_get_contents("http://" . $url . ":" . $port . "/", false, $context);
               }

               if (!(empty($avatarurl))) {
                    $postdata = http_build_query(
                         array(
                              'action' => "changeavatar",
                              'avatarurl' => $avatarurl,
                         )
                    );
                    $opts = array(
                         'http' =>
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
                    $result = file_get_contents("http://" . $url . ":" . $port . "/", false, $context);
               }
          }
     }
}
?>