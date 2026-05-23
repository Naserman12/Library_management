<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'MemberClass.php';
// include "../include/flash.php";
$member = new Member($conn);
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $member->name = $_POST['name'];
    $member->phone = $_POST['phone'];
    $member->email = $_POST['email'];
    $member->password = $_POST['password'];
    $member->avatar = $_POST['avatar'] ?? 'man.png';
    $select = $member->register(
    $member->name,
    $member->email,
    $member->avatar,
    $member->phone,
    $member->password,
    'members'
);
   if($select){
    // setFlash('success', 'تم التسجيل بنجاح');
    // echo "تم التسجيل بنجاح";
    header("Location: ../BOOKS/home.php");
    exit;
} else {
    // setFlash('error', 'فشل في التسجيل');
    // echo "<script>alert('فشل في التسجيل');</script>";
    header("Location: register.php");
    exit;
}
}else{
    echo 'لم يتم استلام البيانات';
}
?>
  <style>
        body{
            padding: 0;
            margin: 0;
            background-color: grey;
        }
    .container{
        text-align: center;
        width: 400px;
        margin: 80px auto;
        padding: 30px;
        background-color: whitesmoke;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h1{
         text-align: center;
         margin-bottom: 20px;
    }
    form{
        display: flex;
        flex-direction: column;
        text-align: center;
    }
    input[type='email'],[type='text'],[type='password']{
        width: 50%;
        padding: 10px;
        border: 1px solid;
    }
    button{
        width: 50%;
        padding: 10px 20px;
        background-color: dodgerblue;
        border: none;
        cursor: pointer;
        margin-top: 10px ;
        font-size: large;
        text-align: center;
    }
    hr{
        width: 50%;
        
    }
    </style>
<h1>تسجيل مستخدم جديد</h1>
<form action="" method="POST" enctype="multipart/form-data">
    <div class=".container">
    <input class="Inpt" required placeholder="الاسم" type="text" name="name" > <br>
    <input class="Inpt" required placeholder="البريد الاكتروني" type="email" name="email"> <br>
    <input class="Inpt" required placeholder="رقم الجوال" type="text" name="phone"> <br>
    <input class="Inpt" required placeholder="كلمة السر" type="password" name="password"><hr><br>
    
    <a href="../admin/login.php"> لديك حساب</a><br><hr>
    <label>الصورة الشخصية:</label><br>
    <!-- عرض الصور كخيارات اختيار للمستخدم -->
            <label>
                <input type="radio" name="avatar" value="eng.jfif">
                <img src="../USERS/profileUser/ImageAvater/eng.jfif" alt="Avatar 1" width="50" height="50">   
            </label>
            <label>
                <input type="radio" name="avatar" value="man.png">
                <img src="../USERS/profileUser/ImageAvater/man.png" alt="Avatar 1" width="50" height="50">
                
            </label>
            <label>
                <input type="radio" name="avatar" value="woman.png">
                <img src="../USERS/profileUser/ImageAvater/woman.png" alt="Avatar 1" width="50" height="50">
                
            </label>
            <label>
                <input type="radio" name="avatar" value="woman2.png">
                <img src="../USERS/profileUser/ImageAvater/woman2.png" alt="Avatar 1" width="50" height="50">
            </label><br>
            <button type="submit">التسجيل</button>
    </div>
</form>
