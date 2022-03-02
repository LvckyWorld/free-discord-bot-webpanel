<?php
session_name("lw-session");
session_start();


$json = file_get_contents("./config.json");
$data = json_decode($json);

$url = $data->serverIP;
$port = $data->port;


if (!empty($_POST['username']) || !empty($_POST['password'])) {
    $username = $_POST['username'];
    $passwordPost = hash("sha256", $_POST['password']);
    $json = file_get_contents("http://".$url.":".$port."/admins");
    $data = json_decode($json);
    
    for ($i = 0; $i<count($data); $i++) {
        $name = $data[$i]->name;
        $password =  $data[$i]->password;
        if ($username == $name && $passwordPost == $password) {
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            header("Location: index.php");
            exit;
        }
    }
} else {

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="center">
        <h1>Login</h1>
        <form method="post" action="./login.php">
            <input class="lo_input" type="text" name="username" placeholder="Username"><br>
            <input class="lo_input" type="password" name="password" placeholder="Password">
            <br>
            <input class="lo_input button" type="submit" value="Login">
        </form>
    </div>
</body>
</html>