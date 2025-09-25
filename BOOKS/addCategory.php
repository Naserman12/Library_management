<?php

include 'category.php';
$category = new category($conn);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['catyName'])) {
       echo "لا يمكنك ترك الحقل فارغ";
       return 0;
    }
    $categoryName = $_POST['catyName'];
     $category->name =  $categoryName;
     $category->saveCaty( $category->name);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>اضافة تصنيف جديد</h1>
    <form action="addCategory.php" method="POST">
    <label for="catyName">اسم التصنيف </label><br>
    <input type="text" name="catyName" required><br>
    <button type="submit">اضافة التصنيف</button>
    </form>
    
</body>
</html>