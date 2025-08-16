<style>
  body{
    background-color: black;
    color: antiquewhite;
  }
</style>
<?php
//  include '../include/db_connect.php';
//  require_once '../BOOKS/Book.php';
 require $_SERVER['DOCUMENT_ROOT']. '/library/BOOKS/Book.php';
//  <--------كلاس الاعضاء-------->
class Member{
    public $conn;
    public $id;
    public $name;
    public $email;
    public $avatar;
    public $phone;
    public $role = 'members';
    public $password;
    public $borrowedBooks;
    public function __construct($db){
        $this->conn = $db;
    }
    
    //  <--------دالة تسجيل الاعضاء-------->
    public function register($name, $email, $avatar, $phone, $password, $role){
        $sql = "SELECT * FROM member WHERE email = '$email'";
        // echo $sql;
        $result = mysqli_query($this->conn,$sql);
        if($result->num_rows > 0){
            // return 'البريد الاكتروني مسجل بالفعل!!.';
            echo 'البريد مسجل بالفعل<br>';
            return false;
        }
        // تشفير كلمة المرور
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = 'INSERT INTO member (name, email, avatar, password, phone, role) VALUES (?, ?, ?, ?, ?, ?)';
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param('ssssss', $name, $email, $avatar, $hashedPassword, $phone, $role);
    
    // تعيين  قيم للمتغيرات
    $name = $this->name;
    $email = $this->email;
    $phone = $this->phone;
    $password = $this->password;
    $role = $this->role;


    if ($stmt->execute()) {
        echo 'تم تسجيل المستخدم بنجاح<br>';
        header( "REFRESH:3; URL = ../admin/login.php"); 
        return true;
    }else{
        echo 'لم يتم تسجيل المستخدم';
        return false;
    }

        
    }
    //  <//--------دالة تسجيل الاعضاء--------//>
    // <---------دالة تسجيل دخول الاعضاء-------->
    public function login($email, $password){
        session_start();
        // $sql = mysqli_query($this->conn, "SELECT *  FROM member WHERE email= '$email' AND password = '$password'");
          $sql = "SELECT * FROM member WHERE email = '$email'";  
          $result = $this->conn->query( $sql );
        if($sql){
            // print_r($sql) ;
            echo '<br>===============<br>';
        }
        if($result->num_rows > 0){
           
            $row =  $result->fetch_assoc();
            // التحقق من كلمة المرور
            if (password_verify($password, $row['password'])) {
                // تخزين بيانات المستخدم في الجلسة 
            $_SESSION['memberId'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            // تعريف المعرف عشان يظهر في صفحة استعارة الكتب
            $this->id = $_SESSION['memberId'];
            $this->role = $_SESSION['role'];
            // echo $_SESSION['memberId']. ' هذا المعرف من صفحة الاعضاء <br>';
            // echo $this->role. ' هذا الدور من صفحة الاعضاء<br>';
            $_SESSION['user_name'] = $row['name'];
            echo 'تم تسجيل الدخول';
            return true;
            } else{
                echo 'كلمة السر غير صحيحة';
                header( "REFRESH:2; URL = ../admin/login.php");
                return false;
            }
        }else{
            echo "<br>لم يتم العثور على المستخدم";
            return false;
            }
        
    }
        //  else{
            // return false; // لم يتم العثور على مستخدم بنفس البريد الالكتروني
        // }

        

    
    // <//---------دالة تسجيل دخول الاعضاء--------//>
    // <---------دالة تسخيل الخروج-------->
    public function logout(){
        // بدء الجلسة إذا لم تكن بدات بالفعل
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        session_unset(); #إزالة جميع متغيرات الجلسة
        // انهاء الجلسة مع حذف البيانات المخرنة وتسجيل الخروج
        session_destroy();

        // نقل المستخدم الى صفحة تسجيل الدخول
        return true;
    }
    // <//---------دالة تسخيل الخروج--------//>
    // <---------دالة استعارة الكتب-------->
    public function borrowedBook($book_id, $memberId, $title){
            // التحقق من حالة الكتاب المستعار مسبقاً
            $sql = "SELECT * FROM borrow_records WHERE book_id = ? AND return_status != 'Confirmed'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('i', $book_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                echo 'تم استعارة الكتاب مسبقاً';
                header( "REFRESH:3; URL = ../BOOKS/home.php");
                return false;
            }
            
        $maxBookAllowed = 3;
        // التاكد من ان العضو لم يستعر اكثر من الحد المسموح به
        $sql = 'SELECT COUNT(*) as totalBorrowed FROM borrow_records where member_id= ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $memberId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['totalBorrowed'] >= $maxBookAllowed) {
            echo 'لقد تجاوزت الحد المسموح به';
            return false;
        }
        // اضافة  استعارة الكتاب الى سجل المستخدم
        $borrowDate = date('Y-m-d H:i:s');
        // الموعد النهائي لارجاع الكتاب
        $returnDate = null; 
        // $returnDate = date('Y-m-d', strtotime('+1 minutes'));
         
            $sql = 'INSERT INTO borrow_records (member_id, book_id, title, borrow_date, return_date) VALUES (?, ?,?, ?, ?)';
            $stmt = $this->conn->prepare($sql);
            echo '<pre>';
            var_dump($stmt);
            echo '</pre>';
            $stmt->bind_param('iisss',  $book_id, $memberId, $title, $borrowDate, $returnDate);
            echo '<pre>';
            print_r($stmt);
            echo '</pre>';
            if($stmt->execute()){
                $updateSql = "UPDATE books SET copies = copies -1 WHERE id = ?";
                $updateStmt = $this->conn->prepare($updateSql);
                    $updateStmt->bind_param("i", $book_id);
                    $updateStmt->execute();
                    return 'تم استعارة الكتاب';
                }else{
            echo 'لم يتم العثور على  معرف الكتاب......';
                }
        
        
    }
    // <//---------دالة استعارة الكتب--------//>
    // <---------returnBook-------->
    public function returnBook($bookId){
        echo 'Memberb Id'. $this->id;
        echo '<br>Book Id' .$bookId;
        // التحقق هل الضعو استعار الكتاب ام لا
        $sql = "SELECT * FROM borrow_records WHERE member_id = ? AND book_id = ?  AND return_date  IS NULL";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            echo "فشل تحضير الاستعلام". $this->conn->error;
           
            return false;
        }
        $stmt->bind_param('ii', $this->id, $bookId);
        // echo '<br>Memberb Id '. $this->id;
        // echo '<br><br>Book Id ' .$bookId;
        if(!$stmt->execute()){
            echo 'فشل تفيذ الستعلام'. $stmt->error;
            return false;
        }
        // $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo 'فشل الحصول على التائج'. $this->conn->error;
            return false;
        }
        // $row = $result->fetch_assoc();
        if ($result->num_rows === 0) {
            // اذا لم يتم العثور على سجل استعارة للكتب
            echo 'لم تقم باستعارة هذا الكتاب';
            return false;
        }

    $returnDate = date('Y-m-d');
    $sql = "UPDATE borrow_records SET  return_date =? WHERE member_id =? AND book_id =?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("sii",$returnDate, $this->id, $bookId);
    if ($stmt->execute()) {
        //    حذف السجل من الجدول
            $sql = 'DELETE FROM borrow_records WHERE member_id =? AND book_id =? ';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('ii', $this->id, $bookId);
    
            $updateSql = "UPDATE books SET copies = copies +1 WHERE id = ?";
            $updateStmt = $this->conn->prepare($updateSql); 
            $updateStmt->bind_param("i", $bookId);
            $updateStmt->execute();
            echo "<br>تم إرجاع الكتاب.<br>";
            return true;
     
    }else{
        echo 'حدث خطأ  لم يتم إرجاع الكتاب';
        return false;
    }
}
// <//---------returnBook--------//>

// <--==========تحديث حالة الطلب==========-->
public function updateBorrowStatus( $bookId,  $status){
    echo $status .'<br>'.$bookId.'<br>';
    
    // عرض الحالة الحالية قبل التحديث
    //     // عرض الحالة الحالية قبل التحديث
    $sqlCheck = "SELECT borrow_status FROM borrow_records WHERE id = ?";
    $stmtCheck = $this->conn->prepare($sqlCheck);
    $stmtCheck->bind_param('i', $bookId);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
    // التحقق إذا كانت النتيجة غير فارغة
    if ($resultCheck && $resultCheck->num_rows > 0) {
        $currentStatus = $resultCheck->fetch_assoc()['borrow_status'];
        echo "الحالة الحالية: " . $currentStatus . "<br>";
    } else {
        echo "لم يتم العثور على السجل مع معرف الكتاب: <br>" . $bookId . "<br>";
        return;  // إيقاف الدالة إذا لم يتم العثور على السجل
    }
    // <--//عرض الحالة الحالية قبل التحديث///-->
    echo $status .'<br>'.$bookId.'<br>';
    $sql = "UPDATE borrow_records SET borrow_status =? WHERE id =?";
    echo $status .'<br>'.$sql.'<br>';
    $stmt = $this->conn->prepare($sql);

    if($stmt === false){
        die("فشل إعداد الاستعلام: " . $this->conn->error);
    }
    $stmt->bind_param('si', $status, $bookId);
    $stmt->execute();
    if($stmt->affected_rows > 0){
        echo "تم تحديث الحالة.";
    }else{
            echo 'لم يتم تحديث الحالة.';
    }
      

    // $stmt->bind_param('i', $status);
}

// <//--==========تحديث حالة الطلب==========--//>
// <--==========تأكيد استرجاع الكتب==========-->
public function confirmReturn($bookId){
        $sql = "UPDATE borrow_records SET return_status ='Confirmed', return_date = ?  WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
            // الحصول على التاريخ الحالي
    $returnDate = date('Y-m-d H:i:s'); // صيغة التاريخ
        // ربط المعاملات
        $stmt->bind_param('si', $returnDate, $bookId);
        // تنفيذ الاستعلام
        if ($stmt->execute()) {
            // التحقق من عدد الصفوف التي تم تحديثها
            if ($stmt->affected_rows > 0) {
                echo "تم تأكيد استرجاع الكتاب بنجاح.";
                return true;
            } else {
                echo "لم يتم تحديث السجل، قد لا يكون موجودًا.";
                return false;
            }
        } else {
            echo "خطأ أثناء تنفيذ الاستعلام: " . $stmt->error;
            return false;
        }
    }
// <//--==========تأكيد استرجاع الكتب==========--//>
//  <--=========عرض بيانات المستخدم=========-->
public function getProfile($memberId){
    // جلب بيانات المستخدم من قاعدة البيانات

$query = "SELECT name, email, avatar, phone FROM member WHERE id = ?";
$stmt = $this->conn->prepare($query);
$stmt->bind_param("i", $memberId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
}
//  <//--=========عرض بيانات المستخدم=========--//>
//  <--=========تحدبث بيانات المستخدم=========-->
public function updateProfile( $name, $email, $phone, $avatar, $user_id){
        // استعلام لجلب آخر وقت تم فيه تعديل رقم الجوال
        $stmt = $this->conn->prepare("SELECT last_phone_update FROM member WHERE id = ?");
        $stmt->bind_param("i", $_SESSION['memberId']); // ربط مع قيمة id
        $stmt->execute();
        $result = $stmt->get_result(); // جلب النتائج
        $row = $result->fetch_assoc(); // جلب الصف كـ مصفوفة
        if ($row) {
            $lastUpdate = $row['last_phone_update'];
            // تاؤيخ اخر تحديث
            $lastUpdateTime = new DateTime($lastUpdate);
            // التاريخ الحالي
            $currentTime = new DateTime();
            // معرفة هل الوقت مناسب لتغير الرقم
            $interval = $lastUpdateTime->diff($currentTime);
            
            // تحقق إذا مر يوم على آخر تعديل
            if ($interval->days < 1 && $lastUpdate != null) {
                echo "يمكنك تعديل البيانات مرة وحدة في كل  24 ساعة.";
                header( "REFRESH:3; URL = showProfile.php"); // إعادة توجيه إلى صفحة الملف الشخصي
            } else {
                // تحديث بيانات المستخدم في قاعدة البيانات
                $query = "UPDATE member SET name = ?, email = ?, phone = ?, avatar =?, last_phone_update = NOW() WHERE id = ?";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param("ssssi", $name, $email, $phone, $avatar,  $user_id);
            
                if ($stmt->execute()) {
                    echo "تم تحديث البيانات بنجاح!";
                 //    header("Location: showProfile.php");
                    header( "REFRESH:3; URL = showProfile.php"); // إعادة توجيه إلى صفحة الملف الشخصي
                    exit();
                } else {
                    echo "حدث خطأ أثناء تحديث البيانات.";
                }
                // هنا يمكن إضافة كود التعديل
            }
        }
   
       $stmt->close();
    }
    //  <//--=========تحدبث بيانات المستخدم=========--//>
    // <--=========تغير كلمة السر========-->
    public function changePassword($password, $newPassword, $confirmPassword){
        $stmt = $this->conn->prepare("SELECT password FROM member WHERE id = ?");
        $stmt->bind_param("i", $_SESSION['memberId']); // ربط مع قيمة id
        $stmt->execute();
        $result = $stmt->get_result(); // جلب النتائج
        $row = $result->fetch_assoc(); // جلب الصف كـ مصفوفة
        $currentPasswordFromDb = $row['password'];
        
        if(password_verify($password, $currentPasswordFromDb)){
            if ($newPassword === $confirmPassword) {
                // تشفير كلمة السر الجديدة
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                // تحديث كلمة السر في قاعدة البيانات
                $stmt = $this->conn->prepare("UPDATE member SET password = ?  WHERE id = ?");
                $stmt->bind_param("si", $hashedPassword, $_SESSION['memberId']);
                $stmt->execute();
                echo "تم تغيير كلمة السر بنجاح!";
                header( "REFRESH:3; URL = showProfile.php"); // إعادة توجيه إلى صفحة الملف الشخصي
                
            } else {
                echo "كلمة السر الجديدة وتأكيدها غير متطابقين.";
                header( "REFRESH:3; URL = showProfile.php"); // إعادة توجيه إلى صفحة الملف الشخصي
            }
        }else {
            echo "كلمة السر الحالية غير صحيحة.";
            header( "REFRESH:3; URL = showProfile.php"); // إعادة توجيه إلى صفحة الملف الشخصي
            }
        }     
    // <//--=========تغير كلمة السر========--//>


// جلب طلبات الاستعارة التي قيد الانتظار
// public function getPendingBooks(){
    //     $sql = "SELECT borrow_records.id, books.title, member.name, borrow_records.borrow_date
//            FROM borrow_records
//            JOIN ON borrow_records.book_id = books.id
//            JOIN member ON borrow_records.member_id = member.id
//            WHERE borrow_status = 'Pending'
//     ";
//     $stmt = $this->conn->prepare($sql);
//     $stmt->execute();
//     $results = $stmt->fetchAll();
//     // return $results;
// }
}
// جلب طلبات الاستعارة التي قيد الانتظار
//  <//--------كلاس الاعضاء--------//>
// <---------=-------->
// $book = new Book($conn);
// $member = new Member($conn);
// // $name = 'nas';
// // $phone ='0536529999';
// $password = '0';
// $email = 'm@m';

// // $result = $member->register( $name, $email,$phone, $password );
// // if ($result) {
// // echo '<br>'. $result;
// // }else{
// //     echo '<br>لم يتم التسجيل';
// // }
// $result= $member->login($email, $password);
// if ($result) {
    // echo ' تم تسجيل الدخول<br>';
    // echo '<br>'. $email. 'البريد'. $password. 'كلمة السر';
    // $bookId = $book->getBookId(3);
//     // $result = $member->borrowedBooks(3);
//     echo '<pre>';
//     print_r( $result);
//     echo '</pre>';
// }
// $result = $member->returnBook(1);
// echo '<br>'. $result;

// $member->borrowedBooks(2);
// print_r($member->borrowedBooks(2));
// update borrow_records set borrow_status = 'accepted' where id = 11;



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة الأعضاء</title>
</head>
<body>
   <h1></h1>
</body>
</html>