<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة الطلبات</title>
    <style>
        body{
            
            text-align: center;
        }
        
        .contaneir-orders{
            width: 100%;
            height: 420px;
            background-color: whitesmoke;
            margin-bottom: 50px;
            color: saddlebrown;
        }
        .contaneir-orders a  {
    width: 90%;
    height: 25px;
    /* background-color: rgb(126, 123, 129); */
    font-size: 18px;
    padding: 10px 20px;
    cursor: pointer;
    text-decoration: none;
}    
    </style>
</head>
<body>
    <h1>صفحة الطلبات</h1>
    <div class="contaneir-orders">
        <a href="borrowBook.php">الكتب المستعارة.</a><br>
        <a href="return_requests.php">طلبات الاسترداد الكتب</a><br>
        <a href="Borrow.php">استعارة كتاب صفحة المستخدم</a><br>
        <a href="returnBook.php">طلب استرداد كتاب صفحة المستخدم</a><br>
        <a href="showBrrow.php">ملخص الكتب</a><br>
        <a href="../BOOKS/listBooks.php">صفحة عرض الكتب والعديل عليها</a>
        <!-- <a href="../BOOKS/editCaty.php?id=<?php echo $row['id']; ?>"></a> -->
    </div>
</body>
</html>