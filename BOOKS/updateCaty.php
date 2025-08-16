<style>
    body{
        background-color: black;
    }
</style>
<?php
include 'category.php';
$category = new category($conn);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval( $_POST['id']);
    $name = $_POST['name'];

    if (!empty($name) && !empty($id)) {
        $category->updateCategory($name,$id );
       echo 'تم تحديث الكتاب بنجاح';
       header( "REFRESH:2; URL = ../admin/adminpanel.php");

    //    header('Location: ../admin/admnpanel.php');
    }else{
        echo 'لم يتم تحديث  الكتاب ';
        header( "REFRESH:2; URL = ../admin/adminpanel.php");
    }
}
?>