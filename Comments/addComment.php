<?php
session_start();
require_once 'comments.php';
if(isset($_POST['AddComm'])){
$book_id = $_POST['book_id'];
$member_id = $_SESSION['memberId'];
$commentad = $_POST['comment'];
$rating = $_POST['rating'];
$comment  = new Comments($conn);
$comment->addComment($book_id,$member_id, $commentad,$rating );
return 0;
}else{
    echo 'لم يتم اارسال طلبك';
    header( "REFRESH:3; URL = ../BOOKS/home.php");
}


?>