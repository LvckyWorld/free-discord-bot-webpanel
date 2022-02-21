<?php
session_name("lw-session");
session_start();


$json = file_get_contents("../config.json");
$data = json_decode($json);

$url = $data->serverIP;
$port = $data->port;


$username = $_SESSION['username'];
$passwordSession = $_SESSION['password'];
if (empty($username) || empty($passwordSession)) {
    header("Location: ../login.php");
    exit;
} else {
    $json = file_get_contents("http://" . $url . ":" . $port . "/admins");
    $data = json_decode($json);

    for ($i = 0; $i < count($data); $i++) {
        $name = $data[$i]->name;
        $password =  $data[$i]->password;
        if ($username == $name && $passwordSession == $password) {
            if ($passwordSession == "2779a3aa8bf314bcdc426d29680e4a9499f5b6d9b285895bf0afc29c5969d5ba") {
                header("Location: ../");
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
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <form id="changeform">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" placeholder="Username"><br>
        <label for="avatarurl">AvatarURL</label><br>
        <input type="text" id="avatarurl" name="avatarurl" placeholder="AvatarURL"><br>
        <div id="formerror" style="color: red;"></div>
        <button type="submit" id="submitbutton">Submit</button>
    </form>
</body>

<script language="javascript">
    let changeform = document.getElementById("changeform");
    let submitbutton = document.getElementById("submitbutton");
    var username = document.getElementById("username");
    var avatarurl = document.getElementById("avatarurl");
    var formerror = document.getElementById("formerror");

    let messages = [];
    changeform.addEventListener("submit", function(event) {
        event.preventDefault();
        if (!(username.value == "" && avatarurl.value == "")) {
            submit(username.value, avatarurl.value);
        } else
            console.log("Error you have to fill in one of the fields");
            messages.push("Error you have to fill in one of the fields");

        if (messages.length > 0) {
            formerror.innerHTML = messages.join(', ')
        }
    });

    function submit(username, avatarurl) {


        sendChangeData({
            "newUsername": username,
            "avatarurl": avatarurl
        });


    }
</script>

<script src="../js/main.js"></script>

</html>