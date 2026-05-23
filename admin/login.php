
<!--============== style================ -->
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
    input[type='email'],[type='password']{
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
  <!--//============== style================// -->
  </head>
<body>
    <main>
<?php
require_once '../include/db_connect.php';
require_once '../USERS/MemberClass.php';

$member = new Member($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo "تأكد من إدخال بيانات صحيحة";
        return;
    }

  $email = trim($_POST['email']);
$password = trim($_POST['password']);

    $login = $member->login($email, $password);

    if ($login) {
        if ($_SESSION['role'] == 'admin') {
            header("Location: ../admin/adminpanel.php");
            exit;
        } else {
            header("Location: ../BOOKS/home.php");
            exit;
        }
    } else {
        echo "<script>alert('بيانات غير صحيحة');</script>";
    }
}
?>
<form method="POST">
    <div class="container">
    <h1 style="color: black;"> تسجيل الدخول</h1>
    <input type="email"  name="email" placeholder="البريد الاكتروني"value="<?php if (isset($_COOKIE['email'])) echo $_COOKIE['email']; ?>"><br>
    <input type="password"  name="password" placeholder="كلمة السر" value="<?php if (isset($_COOKIE['password'])) echo $_COOKIE['password']; ?>"><br>
    <label style="color:black"> <input type="checkbox" name="keep" value="1">تذكرني</label>
    <button type="submit" id="pass" name="submit">تسجيل الدخول</button><br><br>
    <a href="" >نسيت كلمة السر</a><br><br>
    <a href="../USERS/singup.php">ليس لديك حساب</a>
            </form>
        </div>
    </main>
</body>
</html>
