<?php  
require_once('../database/ChatUser.php');
$chat = new ChatUser();
echo json_encode($chat->get_user_all_data());
?>