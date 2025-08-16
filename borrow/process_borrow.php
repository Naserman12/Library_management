<?php
include '../USERS/MemberClass.php';

$newBorrow = new Member($conn);
if(isset($_GET['id']) && isset($_GET['action'])){
   $borrowId = $_GET['id'];
   $action = $_GET['action'];
   echo 'borrow Id: '. $borrowId .'<br>';
   echo 'borrow action: '. $action.'<br>';
   if($action == 'approve'){
       $status = 'Approved';
       echo 'تم قبول الطلب.';
    }elseif($action == 'reject'){
        $status = 'Rejected';
        echo 'تم رفض الطلب.';
}
$newBorrow->updateBorrowStatus($borrowId, $status);
// header('Location: borrowBook.php');
}else{
    echo 'لم يتم التعرف على معرف الكتاب.';
}

?>