
<?php
require_once '../include/session.php';
//  include '../include/db_connect.php';
//  require_once '../BOOKS/Book.php';
//  require $_SERVER['DOCUMENT_ROOT']. '/BOOKS/Book.php';
require_once __DIR__ . '/../BOOKS/Book.php';

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
   public function register($name, $email, $avatar, $phone, $password, $role = 'members')
{
    require_once '../include/session.php';

    $check = $this->conn->prepare("SELECT id FROM member WHERE email = :email");
    $check->execute(['email' => trim($email)]);

    if ($check->rowCount() > 0) {
        // setFlash('error', 'البريد مستخدم مسبقاً');
        echo "<script>alert('البريد مستخدم مسبقاً');</script>";
        return false;
    }
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO member (name, email, avatar, password, phone, role)
            VALUES (:name, :email, :avatar, :password, :phone, :role)";

    $stmt = $this->conn->prepare($sql);

    $result = $stmt->execute([
        'name' => trim($name),
        'email' => trim($email),
        'avatar' => $avatar ?: 'man.png',
        'password' => $hashedPassword,
        'phone' => trim($phone),
        'role' => $role
    ]);

    if ($result) {

        if (!isset($_SESSION['regenerated'])) {
            session_regenerate_id(true);
            $_SESSION['regenerated'] = true;
        }

        $_SESSION['memberId'] = $memberId;
        $_SESSION['role'] = $role;
        $_SESSION['user_name'] = $name;

        // setFlash('success', 'تم إنشاء الحساب بنجاح');
        // echo "تم إنشاء الحساب بنجاح";
        header("Location: ../BOOKS/home.php");
        return true;
    }

    setFlash('error', 'حدث خطأ أثناء التسجيل');
    return false;
}
    //  <//--------دالة تسجيل الاعضاء--------//>
    // <---------دالة تسجيل دخول الاعضاء-------->
public function login($email, $password)
{

    try {

        $sql = "SELECT * FROM member WHERE email = :email LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':email' => $email
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // فحص المستخدم
        if (!$user) {
            return false;
        }

        // التحقق من كلمة المرور
        if (!password_verify($password, $user['password'])) {
            return false;
        }
            // مهم جداً: تأكد session شغالة
       require_once '../include/session.php';
       if (!isset($_SESSION['regenerated'])) {
        session_regenerate_id(true);
        $_SESSION['regenerated'] = true;
       }
        // تخزين بيانات الجلسة
        $_SESSION['memberId'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_name'] = $user['name'];

        return true;

    } catch (PDOException $e) {

        die("Login Error: " . $e->getMessage());

    }
}

    // <//---------دالة تسجيل دخول الاعضاء--------//>
    // <---------دالة تسخيل الخروج-------->
    public function logout(){
        // بدء الجلسة إذا لم تكن بدات بالفعل
      require_once '../include/session.php';
      $_SESSION = [];
        // انهاء الجلسة مع حذف البيانات المخرنة وتسجيل الخروج
        session_destroy();
        // setFlash('success', 'تم تسجيل الخروج بنجاح');
        header('location: ../admin/login.php'); // نقل المستخدم الى الصفحة الرئيسية
        exit();
    }
    // <//---------دالة تسخيل الخروج--------//>
    // <---------دالة استعارة الكتب-------->
    public function borrowedBook($book_id, $memberId, $title){

    // التحقق من حالة الكتاب
    $sql = "SELECT * FROM borrow_records 
            WHERE book_id = :book_id 
            AND return_status != 'Confirmed'";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        ':book_id' => $book_id
    ]);

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        // setFlash('error', 'تم استعارة الكتاب مسبقاً');
        header("Location: ../BOOKS/home.php");
        return false;
    }

    // الحد المسموح
    $maxBookAllowed = 3;

    $sql = "SELECT COUNT(*) as totalBorrowed 
            FROM borrow_records 
            WHERE member_id = :member_id";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        ':member_id' => $memberId
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row['totalBorrowed'] >= $maxBookAllowed) {
        setFlash('error', 'لقد تجاوزت الحد المسموح به');
        return false;
    }

    // إضافة الاستعارة
    $borrowDate = date('Y-m-d H:i:s');
    $returnDate = null;

    $sql = "INSERT INTO borrow_records 
            (member_id, book_id, title, borrow_date, return_date)
            VALUES (:member_id, :book_id, :title, :borrow_date, :return_date)";

    $stmt = $this->conn->prepare($sql);

    if ($stmt->execute([
        ':member_id' => $memberId,
        ':book_id' => $book_id,
        ':title' => $title,
        ':borrow_date' => $borrowDate,
        ':return_date' => $returnDate
    ])) {

        $updateSql = "UPDATE books 
                      SET copies = copies - 1 
                      WHERE id = :id";

        $updateStmt = $this->conn->prepare($updateSql);
        $updateStmt->execute([
            ':id' => $book_id
        ]);
        setFlash('success', 'تم استعارة الكتاب');
        return 'تم استعارة الكتاب';
    }

    return false;
}
    // <//---------دالة استعارة الكتب--------//>
    // <---------returnBook-------->
public function returnBook($bookId){

    $sql = "SELECT * FROM borrow_records 
            WHERE member_id = :member_id 
            AND book_id = :book_id 
            AND return_date IS NULL";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([
        ':member_id' => $this->id,
        ':book_id' => $bookId
    ]);

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) === 0) {
        setFlash('error', 'لم تقم باستعارة هذا الكتاب');
        return false;
    }

    $returnDate = date('Y-m-d');

    $sql = "UPDATE borrow_records 
            SET return_date = :return_date 
            WHERE member_id = :member_id 
            AND book_id = :book_id";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([
        ':return_date' => $returnDate,
        ':member_id' => $this->id,
        ':book_id' => $bookId
    ]);

    // إعادة زيادة النسخ
    $updateSql = "UPDATE books 
                  SET copies = copies + 1 
                  WHERE id = :id";

    $updateStmt = $this->conn->prepare($updateSql);
    $updateStmt->execute([
        ':id' => $bookId
    ]);

    // setFlash('success', 'تم إرجاع الكتاب.');
        // echo "تم إرجاع الكتاب.";
    header("Location: ../BOOKS/home.php");
    return true;
}
// <//---------returnBook--------//>
public function updateBorrowStatus($bookId, $status){

    $sql = "SELECT borrow_status FROM borrow_records WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([':id' => $bookId]);

    $current = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$current) {
        // setFlash('error', 'السجل غير موجود');
        echo "السجل غير موجود";
        return;
    }

    // setFlash('success', "الحالة الحالية: " . $current['borrow_status']);
    echo "الحالة الحالية: " . $current['borrow_status'];
    

    $sql = "UPDATE borrow_records 
            SET borrow_status = :status 
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([
        ':status' => $status,
        ':id' => $bookId
    ]);

    // setFlash('success', 'تم تحديث الحالة.');
    // echo "تم تحديث الحالة.";
     header("Location: ../BOOKS/home.php");
}
// <//--==========تحديث حالة الطلب==========--//>
// <--==========تأكيد استرجاع الكتب==========-->
public function confirmReturn($bookId){

    $sql = "UPDATE borrow_records 
            SET return_status = 'Confirmed',
                return_date = :date
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);

    $result = $stmt->execute([
        ':date' => date('Y-m-d H:i:s'),
        ':id' => $bookId
    ]);

    if ($result) {
        // setFlash('success', 'تم تأكيد الاسترجاع بنجاح');
        echo "تم تأكيد الاسترجاع بنجاح";
        return true;
    }

    return false;
}
// <//--==========تأكيد استرجاع الكتب==========--//>
//  <--=========عرض بيانات المستخدم=========-->
public function getProfile($memberId){

    $query = "SELECT name, email, avatar, phone 
              FROM member 
              WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    $stmt->execute([
        ':id' => $memberId
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
//  <//--=========عرض بيانات المستخدم=========--//>
//  <--=========تحدبث بيانات المستخدم=========-->
public function updateProfile($name, $email, $phone, $avatar, $user_id){

    $stmt = $this->conn->prepare("SELECT last_phone_update FROM member WHERE id = :id");
    $stmt->execute([
        ':id' => $_SESSION['memberId']
    ]);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {

        $lastUpdate = $row['last_phone_update'];
        $lastUpdateTime = new DateTime($lastUpdate);
        $currentTime = new DateTime();
        $interval = $lastUpdateTime->diff($currentTime);

        if ($interval->days < 1 && $lastUpdate != null) {
            setFlash('error', 'يمكنك تعديل البيانات مرة وحدة في كل 24 ساعة.');
            header("Location: showProfile.php");
            exit;
        }

        $query = "UPDATE member SET name = :name, email = :email, phone = :phone, avatar = :avatar, last_phone_update = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':avatar' => $avatar,
            ':id' => $user_id
        ]);

        if ($stmt->rowCount() > 0) {
            setFlash('success', 'تم تحديث البيانات بنجاح!');
            header("Location: showProfile.php");
            exit();
        } else {
            setFlash('error', 'حدث خطأ أثناء تحديث البيانات.');
        }

    } else {
        setFlash('error', 'لم يتم العثور على المستخدم.');
        
    }
}

    //  <//--=========تحدبث بيانات المستخدم=========--//>
    // <--=========تغير كلمة السر========-->
    public function changePassword($password, $newPassword, $confirmPassword){
        $stmt = $this->conn->prepare("SELECT password FROM member WHERE id = :id");
        $stmt->execute([
            ':id' => $_SESSION['memberId']
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $currentPasswordFromDb = $row['password'];
        
        if(password_verify($password, $currentPasswordFromDb)){
            if ($newPassword === $confirmPassword) {
                // تشفير كلمة السر الجديدة
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                // تحديث كلمة السر في قاعدة البيانات
                $stmt = $this->conn->prepare("UPDATE member SET password = :password WHERE id = :id");
                $stmt->execute([
                    ':password' => $hashedPassword,
                    ':id' => $_SESSION['memberId']
                ]);
                // setFlash('success', 'تم تغيير كلمة السر بنجاح!');
                echo "تم تغيير كلمة السر بنجاح!";
                // header( "REFRESH:3; URL = showProfile.php"); // إعادة توجيه إلى صفحة الملف الشخصي
                
            } else {
                // setFlash('error', 'كلمة السر الجديدة وتأكيدها غير متطابقين.');
                echo "كلمة السر الجديدة وتأكيدها غير متطابقين.";
                // header( "REFRESH:3; URL = showProfile.php"); // إعادة توجيه إلى صفحة الملف الشخصي
            }
        }else {
            // setFlash('error', 'كلمة السر الحالية غير صحيحة.');
            echo "كلمة السر الحالية غير صحيحة.";
            // header( "REFRESH:3; URL = showProfile.php"); // إعادة توجيه إلى صفحة الملف الشخصي
            }
        }     
    // <//--=========تغير كلمة السر========--//>



}
//  <//--------كلاس الاعضاء--------//>


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة الأعضاء</title>
    <style>
  body{
    background-color: black;
    color: antiquewhite;
  }
</style>
</head>
<body>
   <h1></h1>
</body>
</html>