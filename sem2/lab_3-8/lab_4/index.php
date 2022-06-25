<?php
$userProfiles;
$messages;

if (file_exists("userProfiles.json")) {
    $userProfiles = json_decode(file_get_contents("userProfiles.json")); 
}
else { file_put_contents("userProfiles.json", ''); 
}
if (file_exists("messages.json")) {
    $messages = json_decode(file_get_contents("messages.json",true)); 
}
else { file_put_contents("messages.json", ''); 
}

$username = $_POST['u_name'];
$password = $_POST['u_pwrd'];
$message = $_POST['u_msg'];
$userData_isCorrect = false;

foreach($userProfiles as $up){
    if($up->name==$username && $up->password==$password){
    	#$new_message = array('sender' => $username, 'content' => $message);
    	#array_push($messages, $new_message);
        #$messages[] = $new_message;
        $messages[] = array('sender' => $username, 'content' => $message)
        $userData_isCorrect = true;
        break;
    }
}
if($userData_isCorrect == false) {
        echo "<br>Error: no matched users found";
}

foreach ($messages as $msg) {
    echo "<br>$msg->sender: $msg->content";
}
file_put_contents("messages.json", json_encode($messages));
