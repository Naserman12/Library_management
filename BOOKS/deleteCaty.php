<?php
include 'category.php';
$category = new category($conn);
if (isset($_GET['id'])) {
   $id = $_GET['id'];
   $id = intval($_GET['id']);
   // echo '<pre>';
   // var_dump($id ) ;
   // echo '</pre>';
    // تحويل الرقم رقم التعريف الى  عدد صحيح
    // $bookId = intval($bookId);
    // محاولة حذف الكتاب
     if ($category->deleteCaty(  $id )) {
             echo 'تم حذف الكتاب';
             header( "REFRESH:1; URL = ../admin/adminpanel.php");
      return  1;
     }
}else{
    echo "لم يتم تحديد معرف الكتاب";
}
?>