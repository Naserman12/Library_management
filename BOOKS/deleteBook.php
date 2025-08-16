<?php
include 'Book.php';
$book = new Book($conn);
if (isset($_GET['id'])) {
    $bookId = ($_GET['id']);
    // تحويل الرقم رقم التعريف الى  عدد صحيح
    // $bookId = intval($bookId);
   //  echo '<pre>';
   //  print_r($bookId) ;
   //  echo '</pre>';
    // محاولة حذف الكتاب
     if ($book->deleteBook( $bookId)) {
        echo 'تم حذف الكتاب';
        header( "REFRESH:2; URL = listBooks.php");
      }else{
         echo 'فشل الحذف';  
         header( "REFRESH:2; URL = listBooks.php");
     }
}else{
    echo "لم يتم تحديد معرف الكتاب";
}