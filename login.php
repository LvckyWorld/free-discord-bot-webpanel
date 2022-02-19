<?php
session_name("lw-session");
session_start();


$url = "127.0.0.1";
$port = "3000";

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
        Login
        <form method="post" action="./login.php">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>