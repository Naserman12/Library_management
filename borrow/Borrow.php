<?php
include '../USERS/MemberClass.php';
session_start();
$member = new Member($conn);
$book = new Book($conn);
$result = $book->getBookId($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrow'])) {

    // if(isset($_SESSION['memberId'])){
    //     echo 'لقد حصلت على معلى المستخدم.';
    // }else{
    //     echo'لم احصل على معرف المستخدم.';
    // }
    // $member->id = $_SESSION['memberId'];
    // echo   $member->id.'<br>عذا معرف الاضعو من صفحة الاستعارة<br>';

   if (isset($_GET['id'])) {
    $book->id = intval( $_GET['id']);
    $memberId = intval($_SESSION['memberId']) ;
    $title = $_POST['title'];
//   var_dump($book->id ) ;
//   var_dump($memberId) ;

    $result = $member->borrowedBook( $book->id, $memberId, $title );
    if ($result) {
        echo "تم استعارة الكتاب بنجاح";
        header( "REFRESH:3; URL = ../BOOKS/home.php");
        exit();
    }
}else{
    echo 'لم يتم الحصول على معرف الكتاب.';
    exit();
}
}
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استعارة الكتب</title>
</head>
<body>
    <h2>استعارة كتاب</h2>
    <form action="" method="POST">
        <input type="hidden" placeholder="رقم العضو" name="member_id" readonly value="<?php echo $_SESSION['memberId'] ?? 'يجب تسجيل الدخول';?>">
        <input type="hidden" placeholder="رقم الكتاب" name="id"  value="<?php echo intval($_GET['id']) ;?>" required >
        <label for="">عنوان الكتاب</label>
        <input type="text" placeholder="عنوان الكتاب" name="title" value="<?php echo $result['title'] ?? "اختر كتاب اخر." ?>" readonly  required >
        <button type="submit" name="borrow">استعارة</button>
    </form>
    
</body>
</html>
<?php
// $conn->close();
?>

