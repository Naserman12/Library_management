<?php
// بناء جلسة
session_start();
// حدف لكل المنشن التي تم حفظها داخل الموقع
session_unset();
// تدمير الجلسة
session_destroy();
// mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الرائيسية</title>
   <style>
    body{
        text-align: center;
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
    }
    h1{
        margin-top: 20px;
    }
    a{  
        text-decoration: none;
    }
    .container{
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 50px;
    }
    .card{
        width: 150px;
        height: 150px;
        text-align: center;
        background-color: #fff;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        transition: transform 0.2s;
    }
    .card img{
        width: 100px;
        height: 100px;
        object-fit: cover;
    }
    .card p{
        margin-top: 35px;
        height: 40px;
        font-size: 16px;
        font-weight: bold;
    }
    .card:hover {
        transform: scale(1.05);
    }
    
   </style>
</head>
<body>
    <h1>اهل بك في المكتبة الالكترونية</h1>
<div class="container">
    <!-- صفحة المدير -->
     <a href="./admin/login.php">
        <div class="card">
            <img src="./images/adminImg.png" alt="">
            <p>المدير</p>
        </div>
    </a>
    <!-- صفحة المستخدم -->
    <a href="./admin/login.php">
        <div class="card">
            <img src=".//images/userImg (1).png" alt="">
            <p>المستخدم</p>
        </div>
     </a>
     <!-- صفحة الزائر -->
     <a href="./BOOKS/home.php">
         <div class="card">
             <img src="images/userImg (1).png" alt="">
             <p>الزائر</p>
        </div>
     </a>
</div>
    
</body>
</html>