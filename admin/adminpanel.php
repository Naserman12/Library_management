<?php
include_once '../BOOKS/category.php';
session_start();
?>
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
       ?>
       <!-- اذا دخل الدير سوف يعرض البيانات التالية -->
       <!-- sidebar  -->
        <div class="sidebar_container">
        <?php
        include_once './sidedar.php';
        ?>
        </div>
        <!--// sidebar  //-->    
       <!-- section -->
          <?php
            // نحدد الصفحة المطلوبة
            $page = $_GET['page'] ?? 'sections'; // القيمة الافتراضية "home"
            
            switch ($page) {
                case 'sections':
                    include_once './catySection.php'; // صفحة التحكم بالأقسام
                    break;
                case 'books':
                    include_once '../BOOKS/listBooks.php'; // صفحة التحكم بالكتب
                    break;
                case 'adBook':
                    include_once '../BOOKS/addBook.php'; //إضافة كتاب
                    break;
                case 'members':
                    include_once '../USERS/showMembers.php'; // صفحة الأعضاء
                    break;
                case 'orders':
                    include_once '../borrow/orders.php'; // الطلبات
                    break;
                case 'return_requests':
                    include_once '../borrow/return_requests.php'; // الطلبات
                    break;
                case 'Borrow':
                    include_once '../borrow/Borrow.php'; // الطلبات
                    break;
                case 'returnBook':
                    include_once '../borrow/returnBook.php'; // الطلبات
                    break;
                case 'news':
                    include './news.php'; // صفحة الأخبار
                    break;
                default:
                    echo "<h2>مرحباً بك في لوحة التحكم</h2>";
                    break;
            }
            ?>
</body>
</html>