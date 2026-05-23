<?php
include '../include/db_connect.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            padding: 0;
            margin: 0;
            background-color: grey;
        }
    .container{
        width: 400px;
        margin: 80px auto;
        padding: 30px;
        background-color: whitesmoke;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h1{
         text-align: center;
         margin-bottom: 20px;
    }
    form{
        display: flex;
        flex-direction: column;
        text-align: center;
    }
    label{
        display: block;
        margin-bottom: 5px;
        padding: 10px;
        font-size: 20px;
    }
    input[type='email'],[type='text']{
        width: 90%;
        padding: 10px;
        border: 1px solid;
    }
    button{
        width: 50%;
        text-align: center;
        padding: 10px 20px;
        background-color: dodgerblue;
        border: none;
        cursor: pointer;
        margin-top: 10px ;
        font-size: large;
    }
    
    </style>
    <title>تسجيل الدخول</title>
</head>
<body>
    <main>
        <?php

if (isset($_POST['add'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo "<script>alert('الرجاء إدخال البريد وكلمة السر');</script>";
    } else {
        $query = "SELECT * FROM admin WHERE email=? AND password=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['role'] = 'admin';
            $_SESSION['email'] = $email;

            header("Location: adminpanel.php");
            exit;
        } else {
            echo "<script>alert('بيانات غير صحيحة');</script>";
        }
    }
}
?>

        <div class="container">
            <h1>تسجيل الدخول </h1>
            <form action="" method="post">
                <label for="em">البريد الإكتروني</label>
                <input type="email" id="em" name="email">
                <label for="pass" >كلمة السر</label>
                <input type="text" name="password">
                <button type="submit" id="pass" name="add">تسجيل الدخول</button>
            </form>

        </div>
    </main>
</body>
</html>