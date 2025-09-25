<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT']. '/BOOKS/category.php';
// require_once $_SERVER['DOCUMENT_ROOT']. '/library/USERS/MemberClass.php';
$dailyPrice = 4;
?>
<!DOCTYPE html>
<html lang="ar">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصفحة الرائيسية</title>
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--// fontawesome //-->
    <link rel="stylesheet" href="/style.css">
  </head>
  <body>
      <!-- الهيدر -->
    <header>
        <div class="container">
            <div class="header-content">
      <!-- logo -->
      <div class="logo"> 
        <!-- <img src="../images/logo1.png" alt="شعار"> -->
        <h1><a href="../BOOKS/home.php">مكتبة الكترونية</a></h1>
      </div>
      <!--// logo // -->
      <?php
$book = new Book($conn);
 $category = new Category($conn); 

            $seachTerm = $_GET['search'] ?? null;
        ?>
        <!-- search -->
                <div class="search">
                    <div class="search_bar">
                      <form action="" method="GET">
                        <input type="search" name="search" class="search_input" placeholder="ابحث عن كتاب أو كاتب..."  value="<?= htmlspecialchars($_GET['search'] ?? '') ; ?>">
                        <button class="search_btn" name="search_btn">
                          <i class="fas fa-search"></i> بحث
                        </button>
                      </form>
                    </div>
                </div>
            <!-- //Search php //-->   
            <!-- cart -->
            <div class="cart">
              <ul>
                <li>
                  <!-- في حال كان المستخدم سجل دخول -->
                  <?php if(isset($_SESSION['memberId'])): ?>
                              <!-- أيقونة المستخدم -->
                  <div class="user-menu" id="userMenu">
                    <button  class="user-toggle">
                      <i class="fas fa-user-circle"></i>
                    </button>
                    <!-- القائمة المنسدلة -->
                    <div class="user-dropdown" id="userDropdown">
                      <a href="../USERS//profileUser/showProfile.php"> <i class="fas fa-user-circle"></i> الملف الشخصي</a>
                      <a href="../admin/logout.php" onclick="return confirm('هل تريد تسجيل الخروج؟')">🚪 تسجيل الخروج</a>
                    </div>
                  </div>
                    <?php else:
                   ?>
                   <!-- في حال لم يسجل -->
                 <a href="../admin/login.php" onclick="return 'سيتم نقلك لصفحة الدخول';">|<i class="fa-solid fa-user">|تسجيل دخول</i></a>
                 <?php
               endif; ?>
               </li> 
            </ul>
            </div>
            <!--// cart //-->
    </div>
    </div>
  </header>
