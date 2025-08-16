<style>
  body{
    background-color:black;
    color: antiquewhite;
  }
</style>
<?php
include 'Book.php';

$book = new Book($conn);
if (isset($_POST['upload'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author =$_POST['author'];
    $category = $_POST['category'];
    $year = $_POST['year'];
    $detil = $_POST['detil'];
    $copies = $_POST['copies'];
    $img = $_FILES['image'];
        // الصورة وصيغة الصور
        $img_location = $_FILES['image']['tmp_name'];
        $img_name=$_FILES['image']['name'];
        // ملف رفع الصور
       $img_up = "../images/".$img_name;

    if ($book->updateBook( $title, $author, $category, $year, $detil, $copies,   $img_up , $id)) {
       echo 'تم تحديث الكتاب بنجاح';
       header( "REFRESH:2; URL = listBooks.php");

    //    header('Location: listBooks.php');
    }else{
        echo 'لم يتم تحديث  الكتاب ';
    }
}
?>