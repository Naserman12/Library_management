<?php
include '../USERS/MemberClass.php';
session_start();
$member = new Member($conn);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['returnBook'])) {
    $member->id = $_SESSION['memberId'];
    echo   $member->id.'<br>هذا معرف العضو من صفحة الاسترجاع<br>';

   if (isset($_POST['book_id'])) {
       $bookId = $_POST['book_id'];
       $result = $member->returnBook( $bookId );
       if ($result) {
           echo "تم استرجاع الكتاب بنجاح";
           return true;
       }
   }
}else{
    echo "يرجى تسجيل الدخول أولا";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استرجاع الكتب</title>
</head>
<body>
    <h2>استرجاع كتاب</h2>
    <form action="" method="POST">
        <input type="text" placeholder="رقم العضو" name="member_id" value="<?php echo $_SESSION['memberId'] ?? 'يجب تسجيل الدخول';?>">
        <input type="text" placeholder="رقم الكتاب"name="book_id" required>
        <button type="submit" name="returnBook">استرجاع الكتاب</button>
    </form>

</body>
</html>
<?php 
$conn->close();
?>