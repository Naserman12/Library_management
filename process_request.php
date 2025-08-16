<?php 
include 'include/db_connect.php';

session_start();
if(isset($_SESSION['memberId'])){
    
    

// التحقق من وجود بيانات في النموذج
// include "admin/login.php";
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلب كتاب</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
}

.container {
    width: 300px;
    margin: 0 auto;
    padding: 20px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
}

label {
    display: block;
    margin: 10px 0 5px;
}

input, textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ced4da;
    border-radius: 4px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

</style>
    <link rel="stylesheet" href="styles.css"> <!-- إذا كان لديك ملف CSS -->
</head>
<body>
    <div class="container">
        <h1>ملاحظات</h1>
        <form action="process_request.php" method="POST">
            <label for="bookId">عنوان الكتاب:</label>
            <input type="text" id="bookId" required name="bookId">

            <label for="memberId">رقم العضو:</label>
            <input type="text" id="memberId" name="memberId" readonly value="<?php echo $_SESSION['memberId'] ?>" required>

            <label for="comment">ملاحظات إضافية:</label>
            <textarea id="comment" name="comment"></textarea>

            <button type="submit">إرسال الطلب</button>
        </form>
    </div>
</body>
</html>
<?php
// session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // echo 'تم بدأ الجلسة.';
    $bookId = isset($_POST['bookId']);
    if(!intval($bookId)){
        echo 'الرجاء تحديد معرف الكتاب.';
    }
    $memberId = $_SESSION['memberId'];
    $comment = $_POST['comment'];
    $sql = "INSERT INTO requests (book_id, member_id, comment) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $bookId, $memberId, $comment);

    if ($stmt->execute()) {
        echo "تم إرسال الطلب بنجاح!";
    } else {
        echo "خطأ في إرسال الطلب: " . $conn->error;
    }
}
}else{
    echo "الرجاء تسجيل الدخول !!.";
    header( "REFRESH:3; URL = admin/login.php");
}


    // إغلاق الجملة والاتصال
    // $stmt->close();
$conn->close();
?>