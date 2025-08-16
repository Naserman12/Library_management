<?php
include '../USERS/MemberClass.php';
$returnBook = new Member($conn);

if(isset($_GET['id'])){
    $borrowId = $_GET['id'];
    echo 'borrow Id: '. $borrowId;

if($returnBook->confirmReturn($borrowId)){
    echo "لقد تم استرجاع الكتاب.";
}else{
    echo "فشل استرجاع الكتاب.";
}
// header( 'Location: return_requests.php');
}
?>