<?php
// require_once $_SERVER['DOCUMENT_ROOT']. '/library/include/db_connect.php';
require_once "Discussion.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_SESSION['memberId'])) {
        $comment = new Comments($conn);
        $discussion_id = $_POST['discussion_id'];
        $memberId = $_SESSION['memberId'];
        $content = $_POST['comment_content'];
        $addComment = $comment->addComment($discussion_id, $memberId, $content);
        if($addComment){
            //  echo "<pre>";
            //  var_dump($addComment);
            //  echo "</pre>";
        }
    }else{
        echo "يرجى تسجيل الدخول حتى تتمكن من التعليق!!.";
        header( "REFRESH:3; URL = showDiscussions.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة تعليق</title>
</head>
<body>
    
</body>
</html>