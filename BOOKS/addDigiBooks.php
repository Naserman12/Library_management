<?php
require_once 'category.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// استقبال البيانات من النموذج
$title = $_POST['title'];
$author = $_POST['author'];
$year = $_POST['year'];
$copies = $_POST['cpoies'];
$category = $_POST['category'];
$detil = $_POST['detil'];
}

?>
<style>
        /* تنسيق أساسي */
body {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background-color: #f5f5f5;
    font-family: Arial, sans-serif;
    color: black;
}

/* تنسيق الحاوية */
.select-container {
    width: 200px;
    text-align: center;
}

.select-container label {
    display: block;
    margin-bottom: 8px;
    font-size: 1em;
    color: #333;
}

/* تنسيق قائمة الخيارات */
select {
    width: 100%;
    padding: 10px;
    font-size: 1em;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #fff;
    color: #333;
    cursor: pointer;
    appearance: none; /* إزالة السهم الافتراضي */
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%234CAF50' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E"); /* سهم مخصص */
    background-repeat: no-repeat;
    background-position: right 10px center;
}

/* تنسيق إضافي عند تمرير الفأرة */
select:hover {
    border-color: #4CAF50;
}

/* تنسيق عند التركيز */
select:focus {
    outline: none;
    border-color: #4CAF50;
    box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
}
    </style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة كتاب</title>
</head>
<body>
    <form action="addBook.php" method="POST">
        <label for="">العنوان:</label>
        <input type="text"><br>
        <label for="">المؤلف:</label>
        <input type="text"><br>
        <label for="">سنة النشر:</label>
        <input type="text"><br>
        <label for="">عدد النسخ:</label>
        <input type="text"><br>
        <!-- اختيار نوع الكتاب -->
        <label for="">نوع الكتاب:</label><br>
        <input type="radio" id="DigiRadio" name="bookType" value=" الكتروني" >
        <label for="paper">الكتب الورقية:</label>
        <input type="radio" id="paperRadio"  name="bookType" value="ورقي" checked>
        <label for="Digi">الكتب الإلكترونية:</label>
        <!-- الروابط للكتب -->
         <br>
         <div id="DigiOption" style="display: none;">
             <label for="">رابط التحميل</label>
             <input type="text" name="downlaodLink"><br>

             <label for="">رابط  القراة</label>
             <input type="text" name="readLink">
            </div>
             <!--/====================Images=================-->
            <br><hr>
            <input type="file" id="file" class="btn" style="display:none;" name="image" required>
            <label for="file">اختر صورة</label>
            <!-- <button class="edt-btn" name="submit" >رفع الصورةّ</button> -->
            <br><hr>
            <!--//====================Images=================//-->
            <!-- اختيار نوع الكتاب -->
            <button type="submit">إضافة الكتاب</button>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            let DigiRadio =document.getElementById("DigiRadio");
            let paperRadio =document.getElementById("paperRadio");
            let DigiOption =document.getElementById("DigiOption");

            DigiRadio.addEventListener("change", function(){
                if (DigiRadio.checked) {
                    DigiOption.style.display = "block";
                }
            });
            paperRadio.addEventListener("change", function(){
                if (paperRadio.checked) {
                    DigiOption.style.display = "none";
                }
            });
        })
    </script>
    
</body>
</html>