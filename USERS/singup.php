<?php
include 'MemberClass.php';
$member = new Member($conn);
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $member->name = $_POST['name'];
    $member->phone = $_POST['phone'];
    $member->email = $_POST['email'];
    $member->password = $_POST['password'];
    $member->avatar = $_POST['avatar'];
    $select = $member->register( $member->name, $member->email, $member->avatar ,$member->phone,$member->password,  $member->role);
    // $targetDir = "../ImageAvatar";
    // $upload = 1;
    // $targetFile = $targetDir . basename($member->avatar['name']);
    // $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // التحقق من ان الملف صولاة
    // $check = getimagesize($member->avatar['tmp_name']);
    // if ($check) {
    //    $upload = 1 ;
    // }else{
    //     $upload = 0;
    // }
    // if ($upload && move_uploaded_file($member->avatar['tmp_name'], $targetFile) ) {
    //     # حفظ مسار الصورة في قاعدة البيانات
        // $avatarPath = $targetFile;
       
    // }
    // echo '<br>================<br>';
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
