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
    <div class="box">
        <?php
            $json1 = file_get_contents("http://".$url.":".$port."/userlist");
            $data1 = json_decode($json1);


            foreach ($data1 as $key => $value) {
                if (!empty($value->avatarURL)) {
                    $avatarURL = $value->avatarURL;
                } else {
                    $avatarURL = "https://cdn.discordapp.com/avatars/873639725171359814/527e4f194fc8dd32acf5667cae2d7745.webp";
                }

                echo '
                
                <div class="card">
                    <div class="flipcardfront">
                        <img src="'.$avatarURL.'" alt="Avatar" style="width:100%; border-top-left-radius:  12px; border-top-right-radius:  12px;">
                        <div class="container">
                                <h4><b>'. $value->name .'</b></h4> 
                                <p>' . $value->id  . '</p> 
                        </div>
                    </div>
                    <div class="flipcardback">
                        <div class="container">
                                <p class="flipcardback-text" name="' . $value->id  . '">' . $value->id  . '</p>
                                <input type="submit" onclick="submit(\'' . $value->id  . '\')" value="Ban User" class="ban-button"></input>
                        </div>
                    </div>
                </div>

                ';
            }
        ?>
       
    </div>
    <script language="javascript">
        function submit(id) {
            console.log(id);
            let userID = String(id);
            let reason = prompt("Enter reason for ban:", "Reason");
            sendData({
                "userID": userID,
                "reason": reason
            });

            location.reload();
        }
    </script>
</body>
<script src="js/main.js"></script>
</html>