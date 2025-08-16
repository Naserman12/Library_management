<?php
session_start();
require_once "../../include/db_connect.php";
if(!isset($_SESSION['memberId'])){
    echo "سجل دخول لعرض هذه الصفحة!!.";
    header( "REFRESH:3; URL = ../../admin/login.php");
}
 
        // جلب بيانات المستخدم من قاعدة البيانات
    $memberId = $_SESSION['memberId'];
    $query = "SELECT name, email, avatar, phone FROM member WHERE id = $memberId";
    $result = $conn->query($query);
    $user = $result->fetch_assoc();
    // $pathavataer = $user['avatar'];
    // القيمة بالكلاس
    // echo " <pre>";
    // var_dump($user['avatar']);
    // echo " </pre>";
    // القيمة في مصفوفة
    // echo " <pre>";
    // print_r($user['email']);
    // echo " </pre>";
   

?>
<?php //echo "<img src='ImageAvater/".$user['avatar']."' alt='صورة شخصية'><br>" ?>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background-color: #f5f5f5;
}

.profileContainer {
    width: 300px;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    text-align: center;
}

.profileContainer h2 {
    margin-bottom: 20px;
    color: #333;
}

.profileContainer label {
    display: block;
    text-align: right;
    margin-bottom: 5px;
    color: #666;
    font-size: 0.9em;
}

.profileContainer input[type="password"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.profileContainer button {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1em;
}

.profileContainer button:hover {
    background-color: #45a049;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملف المستخدم</title>
</head>
<body>
    <div class="profileContainer">

        <h1>بيانات المستخدم</h1>
       
            <form action="updateProfile.php" method="post">
            <a href="updateAvatar.php"><?php echo "<img src='ImageAvater/".$user['avatar']."' alt='صورة شخصية'  width='80' height='80'>"; ?></a><br>
        
                <label>الاسم:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br>
        
                <label>البريد الإلكتروني:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>
        
                <label>رقم الهاتف:</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"><br>
        
                <label>كلمة السر</label>
                <input type="password" name="currentPassword" value="*********" readonly><a href="changePass.php?id=<?php echo $_SESSION['memberId'] ?>">تغير كلمة السر</a><br>
        
                <button type="submit">تحديث البيانات</button>
            </form>
    </div>
    
</body>
</html>
