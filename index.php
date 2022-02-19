<?php
session_name("lw-session");
session_start();


$url = "127.0.0.1";
$port = "3000";

$username = $_SESSION['username'];
$passwordSession = $_SESSION['password'];
echo $username;
if (empty($username) || empty($password)) {
    header("Location: login.php");
    exit;
} else {
    $json = file_get_contents("http://".$url.":".$port."/admins");
    $data = json_decode($json);
    
    for ($i = 0; $i<count($data); $i++) {
        $name = $data[$i]->name;
        $password =  $data[$i]->password;
        if ($username == $name && $passwordSession == $password) {

        } else {

        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>