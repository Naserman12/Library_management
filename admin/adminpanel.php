<?php
// include '../include/db_connect.php';
// include '../USERS/MemberClass.php';
include_once '../BOOKS/category.php';
session_start();
?>
<style>
        
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--// fontawesome //-->
    <link rel="stylesheet" href="styleAdmin.css">
    <title>لوحة التحكم</title>
</head>
<body>    
    <?php
   
    if ($_SESSION['role'] != 'admin') {
        echo'لا يمكن الوصول لهذه الصفحة يحب تسجيل الدخول!!';
        header( "REFRESH:2; URL = login.php");
        
        
        exit();
    }
$category = new category($conn);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['catyName'])) {
        echo "لا يمكنك ترك الحقل فارغ";
        return 0;
     }
    $categoryName= $_POST['catyName'];
     $category->name =  $categoryName;
     $category->saveCaty( $category->name);
     header( "REFRESH:2; URL = adminpanel.php");  
}
    // اذا لم يسجل المدير فإنه ينتقل الى الصفحة الرائيسية
//     if (!isset($_SESSION['email']) ){ 
//     header('location:../index.php');
//    }else{
       ?>
       <!-- اذا دخل الدير سوف يعرض البيانات التالية -->

       <!-- sidebar  -->
        <div class="sidebar_container">
            <div class="sidebar">
                <!-- الصفحة الجانبية -->
            <h1>لوحة التحكم</h1>
            <ul>
                <li><a href="../BOOKS/home.php" target="_blank"> الرائيسية <i class="fa-solid fa-home"></i></a></li>
                <li><a href="../Borrow/orders.php" target="_blank"> الطلبات <i class="fa-solid fa-folder-open"></i></a></li>
                <li><a href="../USERS/showMembers.php" target="_blank"> الاعضاء <i class="fa-solid fa-users"></i></a></li>
                <li><a href="../BOOKS/listBooks.php" target="_blank"> الكتب<i class="fa-solid fa-water"></i></a></li>
                <li><a href="../BOOKS/addBook.php " target="_blank">إضافة كتاب<i class="fa-solid fa-folder-plus"></i></a></li>
                <li><a href="../USERS/Discussion/Add_discussion.php " target="_blank">إضافة بوست<i class="fa-solid fa-folder-plus"></i></a></li>
                <li><a href="logout.php" target="_blank">تسجيل الخروج<i class="fa-solid fa-right-from-bracket"></i></a></li>
            </ul>
            <!--// الصفحة الجانبية //-->
            </div>
       <!-- section -->
        <div class="content_sec">
            <form action="adminpanel.php" method="POST">
                <label for="section" >التحكم بالاقسام</label>
                <input type="text" name="catyName" class="section"  required>
                <br>
                <button class="add" type="submit"><i class="fa-solid fa-plus"></i>اضافةالقسم</button>
            </form>
            <br>
            <!-- tatel -->
            <table dir="rlt">
                <!-- عناوين الجدول -->
                <tr>
                    <th>الرقم التسلسلي</th>
                    <th>القسم</th>
                    <th>تعديل القسم</th>
                    <th>حذف القسم</th>
                </tr>
                <!--// عناوين الجدول //-->
                <?php
                // $category =  mysqli_query($conn,"SELECT * FROM  categories");
                $category = $category->getCaty();
                 foreach($category as $row): ?>
                <!-- بيانات الجدول -->
                <tr>
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['name'] ?></td>
                    
                    <td><a href="../BOOKS/editCaty.php?id=<?php echo $row['id']; ?>"><i class="fa-solid fa-edit"></i>تعديل</a></td>
                    <td><a  class="del_btn" onclick="return confirm('هل انت تريد حذف التصنيف؟؟.')"  href="../BOOKS/deleteCaty.php?id=<?php echo $row['id']; ?>">حذف</a></td>
                    <!-- <button class="del_btn"  type="submit">حذف</button> -->
                </tr>
                <!--// بيانات الجدول //-->
                <?php endforeach; ?>
             
                </table>
                <!--// tatel //-->
        <?php
    include '../showNews.php';
   ?>
            </div>
            <!--// section //-->
        </div>
     <!--// sidebar  //-->
   <!-- <script> -->
    <!-- // تسجيل الخروج بعد الخروج من الصفحة
    // window.addEventListener('beforeunload', function(){
    //     navigator.sendBeacon('../USERS/logout.php')
    // }) -->
    <!-- </script> -->
</body>
</html>