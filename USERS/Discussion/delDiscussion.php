<?php
include "Discussion.php";
$discussion = new Discussion($conn);
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $_GET['id'];
    //  echo $_GET['id'];
    if (isset($_GET['id'])) {
        $discussionId = ($_GET['id']);
        intval( $discussionId);

        // محاولة حذف الكتاب
         if ($discussion->deleteDiscussion( $discussionId)) {
            echo 'تم حذف الكتاب';
            header( "REFRESH:2; URL = Add_discussion.php");
          }else{
             echo 'فشل الحذف';  
             header( "REFRESH:2; URL = Add_discussion.php");
         }
    }else{
        echo "لم يتم تحديد معرف الكتاب";
    }
// }
?>
