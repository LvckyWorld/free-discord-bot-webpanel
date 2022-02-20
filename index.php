<?php
session_name("lw-session");
session_start();


$json = file_get_contents("./config.json");
$data = json_decode($json);

$url = $data->serverIP;
$port = $data->port;


$username = $_SESSION['username'];
$passwordSession = $_SESSION['password'];
if (empty($username) || empty($passwordSession)) {
    header("Location: login.php");
    exit;
} else {
    $json = file_get_contents("http://".$url.":".$port."/admins");
    $data = json_decode($json);
    
    for ($i = 0; $i<count($data); $i++) {
        $name = $data[$i]->name;
        $password =  $data[$i]->password;
        if ($username == $name && $passwordSession == $password) {
            if ($passwordSession == "2779a3aa8bf314bcdc426d29680e4a9499f5b6d9b285895bf0afc29c5969d5ba") {
                echo '
                <!DOCTYPE html>
                
                <link rel="stylesheet" href="styles.css">
                <html lang="en">
                    <div class="overlay">
                        <div class="changePassword">
                            <form method="post" action="./changePassword.php">
                                <input type="password" name="password" placeholder="Password" required>
                                <input type="password" name="password1" placeholder="Password Again" required>

                                <input type="submit" value="Change Password">
                            </form>
                        </div>
                    </div>
                </html>
                
                ';
                exit;
            }
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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
</body>
<script src="js/main.js"></script>
</html>