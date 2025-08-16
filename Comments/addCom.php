<?php
// require_once '../USERS/MemberClass.php';
session_start();
if(isset($_SESSION['memberId'])){
?>
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

.addcom {
    width: 300px;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    text-align: center;
}

.addcom h2 {
    margin-bottom: 20px;
    color: #333;
}

.addcom label {
    display: block;
    text-align: right;
    margin-bottom: 5px;
    color: #666;
    font-size: 25px;
    color: black;
}

.addcom input[type="password"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.addcom button {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1em;
}

.addcom button:hover {
    background-color: #45a049;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التعليقات</title>
</head>
<body>
    <div class="addcom">

        <h3>اضافة تعليق</h3>
        <form action="addComment.php" method="POST">
            <input type="hidden" name="book_id" value="<?php echo $_GET['book_id']; ?>">
            <textarea name="comment" placeholder="اكتب تعليقك هنا" id=""></textarea><br>
            <label>القييم:</label>
            <select name="rating" id="">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select><br>
            <button type="submit" name="AddComm">إضافة التعليق</button>
        </form>
    </div>
</body>
</html>
<?php
}else{
    echo 'يجب تسجيل الدخول اولا!!.';
    header( "REFRESH:3; URL = ../BOOKS/home.php");
}
?>