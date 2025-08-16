<?php
include 'MemberClass.php';

session_start();
    
$member = new Member($conn);
if($_SERVER['REQUEST_METHOD'] == 'POST'){
         $member->email = $_POST['email'];
         echo $member->email;
         $member->password = $_POST['password'];
         echo $member->password;
         $select = $member->login($member->email, $member->password);
        if($select == true){ 
            // $member->borrowedBooks(14);
// print_r($member->borrowedBooks(14));

        
        //  echo '<pre>';
        //  var_dump( '<br> قمية صفحة تسجيل الدخول = '. $member->login($member->email,$member->password ));
        //  echo '</pre>';
        ?>
        <a href="../borrow/Borrow.php?id=<?php echo $_SESSION['id']; ?>">استعارة كتاب</a>
        <a href="../borrow/returnBook.php?id=<?php echo $_SESSION['id']; ?>">استرجاع الكتاب</a>
        <a href="logout.php">تسجيل الخروج</a>
        <?php
        }
    }
?>
<form method="POST">
    <h1> تسجيل الدخول</h1>
    <input type="email" required name="email" placeholder="البريد الاكتروني"><br>
    <input type="password" required name="password" placeholder="كلمة السر"><br>
    <button type="submit" name="submit">تسجيل الدخول</button><br>
    <span><a href="singup.php"></a><small>ليس لديك حساب</small></a></span>
</form>
