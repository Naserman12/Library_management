<?php
include '../include/db_connect.php';
session_start();
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

$ADemail = $_POST['email'];
$ADpassword = $_POST['password'];
if (isset($_POST['add'])) {
    if (empty($ADemail) || empty($ADpassword)) {
        
        echo "'<script>alert ('الرجاء ادخال كلمة السر والبريد الاكتروني')</script>'";
    }else{
        $query= "SELECT * FROM admin WHERE email='$ADemail' AND password='$ADpassword'";
        $result = mysqli_query($conn, $query);
        // echo $ADemail.'<br> Result is:'.$result ;
         if (mysqli_num_rows($result) >0) {
        $_SESSION['email']= $ADemail;
        echo "'<script>alert ('الرجاء الانتظار سيتم نتقلك الى صفحة التحكم')</script>'";
        header( "REFRESH:1; URL = adminpanel.php");
    }else{
        echo "'<script>alert ('الرجاء الانتظار سيتم نتقلك الى المتجر')</script>'";
        header( "REFRESH:1; URL = ../index.php");

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