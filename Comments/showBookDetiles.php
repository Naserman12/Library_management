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
    <title>عرض تفاصيل الكتاب</title>
</head>
<body>
    <div class="showBooksContainer">

        <?php
require_once 'comments.php';
$comment = new Comments($conn);
$book_id = $_GET['book_id'];
$comm1 = $comment->showDetils($book_id);
$comm2 = $comment->averageRaing($book_id);
    ?>
    <h1>عرض تفاصيل الكتاب</h1>
    <a href="addCom.php?book_id=<?php echo $book_id;?>">أضافة تعليق</a>
    <?php
    $comment->showComments($book_id);
    ?></php>
</div> 
</body>
</html>