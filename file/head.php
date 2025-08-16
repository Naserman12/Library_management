<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT']. '/library/BOOKS/category.php';
// require_once $_SERVER['DOCUMENT_ROOT']. '/library/USERS/MemberClass.php';

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
    <link rel="stylesheet" href="../style.css">
  </head>
  <body>
    <header>
      <!-- logo -->
      <div class="logo">
        
        <img src="../images/logo1.png" alt="شعار">
        <h1><a href="">مكتبة الكترونية</a></h1>

      </div>
      <!--// logo // -->
      <?php

$book = new Book($conn);
 $category = new Category($conn);
//  $member = new Member($conn);
  // $result = $book->getBook();
// echo  $book->getBook() .'<br> done';
    // if ($result) 

      $seachTerm = $_GET['search'] ?? null;
        ?>
        <!-- search -->
        <div class="search">
            <div class="search_bar">
                 <form action="" method="GET">
                    <input type="search" name="search" class="search_input" placeholder="ادخل كلمة البحث" value="<?= htmlspecialchars($_GET['search'] ?? ''); ?>">
                    <button class="search_btn" name="search_btn">بحث</button>
                    
       
                </form>  
              </div>
            </div><br><br>
                     <!-- //Search php //-->
          
               
            <!-- last post -->
            <div class="last-post">
    <h4>مضاف حديثا</h4>
    <ul>
    <li>
     <?php
         // جلب اخر ثلاث اضافات 
         $sql_latest = "
         SELECT id, title, author, image, created_at 
         FROM books 
         ORDER BY created_at DESC 
         LIMIT 3
     ";
     $result = $conn->query($sql_latest);
     if ($result === false) {
          // عرض رسالة خطأ إذا فشل الاستعلام
          echo "خطأ في الاستعلام: " . $conn->error;
     }
     if ($result->num_rows > 0) {
         $featuredBook =[];
        // عرض احدث الكتب
         while ($row = $result->fetch_assoc()) {
             $featuredBook[] = $row;
             ?>
             <!-- الانتقال لصفحة عرض تفاصيل الكتاب -->
       <a href="../Comments/showBookDetiles.php?book_id=<?php echo $row['id'];?>">
             <span class="span-img">
               <img src="<?php echo $row['image'];?>" alt="span-img">
             </span>
       </a>
             <?php
         }
     }
     ?>
    
    <!-- cart -->
    <div class="cart">
      <ul>
        <li>
          <!-- في حال كان المستخدم سجل دخول -->
          <?php if(isset($_SESSION['memberId'])): ?>
            <a href="../admin/logout.php" onclick="return confirm('هل انت تريد تسجيل الخروج!!.')">تسجيل خروج</a>||<a href="../USERS//profileUser/showProfile.php"><i class="fa-solid fa-user"></a></i>
            <!-- <h2 style="color:black; text-align:center; font-size:large; text-decoration:none;" dir="rtl"><a href="../DigiBooks/showDigiBooks.php">|الكتب الإلكترونية| </a></h2> -->
            <?php else:
           ?>
           <!-- في حال لم يسجل -->
         <a href="../admin/login.php" onclick="return 'سيتم نقلك لصفحة الدخول';">|<i class="fa-solid fa-user">|تسجيل دخول</i></a>
         <?php
       endif; ?>
       </li> 
       <!-- <li class="cart-icon">
           <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
           <span class="cart_count">0</span>
       </li> -->
    </ul>
    </div>
    <!--// cart //-->
    </div>
    
    <!--// last post// -->
  </header>
  