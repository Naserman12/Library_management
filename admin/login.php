
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
include '../USERS/MemberClass.php';
// session_start();
$member = new Member($conn);
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (empty($_POST['email']) || empty($_POST['password'])) {
       echo " تأكد من ادخال بيانات صحيحة";
       return 0;
       }
         $member->email = htmlspecialchars($_POST['email']);
         $member->password =htmlspecialchars($_POST['password']);
         if (isset($_POST['keep'])) {
            $keep = htmlspecialchars($_POST['keep']);
            if ($keep==1) {
              setcookie('email',$member->email, time()+3600, "/");
              setcookie('password',$member->password, time()+3600, "/");
            }
         }
         $select = $member->login($member->email, $member->password);
         if($select == true){
             if ($_SESSION['role'] == 'admin') {
                 echo "'<script>alert ('الرجاء الانتظار سيتم نتقلك الى صفحة التحكم')</script>'";
                 header( "REFRESH:3; URL = adminpanel.php");
                 return 0;
                }elseif ($_SESSION["role"] == "members") {
            echo "'<script>alert ('الرجاء الانتظار سيتم نتقلك الى المكتبة')</script>'";
            header( "REFRESH:3; URL = ../BOOKS/home.php");
            return 0;
            }

        ?>
        <a href="../borrow/Borrow.php?id=<?php echo $_SESSION['memberId']; ?>">استعارة كتاب</a><br>
        <a href="../borrow/returnBook.php?id=<?php echo $_SESSION['memberId']; ?>">استرجاع الكتاب</a><br>
        <a href="../process_request.php?id=<?php echo $_SESSION['memberId']; ?>">طلب كتاب</a><br>
        <a href="logout.php">تسجيل الخروج</a>
        <?php
        }
    }else{
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
        <?php
}
?>
        </div>
    </main>
</body>
</html>
