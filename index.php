<?php
session_name("lw-session");
session_start();


$url = "127.0.0.1";
$port = "3000";

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

        } else {
            session_destroy();
            header("Location: login.php");
            exit;
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
    <div class="box">
        <?php
            $json1 = file_get_contents("http://".$url.":".$port."/userlist");
            $data1 = json_decode($json1);


            foreach ($data1 as $key => $value) {

                echo '
                
                <div class="card">
                    <img src="'.$value->avatarURL.'" alt="Avatar" style="width:100%; border-top-left-radius:  12px; border-top-right-radius:  12px;">
                    <div class="container">
                            <h4><b>'. $value->name .'</b></h4> 
                            <p>' . $value->id  . '</p> 
                    </div>
                </div>

                ';
            }
        ?>
       
    </div>
</body>
</html>