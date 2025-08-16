<?php
include '../USERS/MemberClass.php';
session_start();

if(isset($_SESSION['memberId'])){
// إعداد استعلام جلب الطلبات المعلقة
$sql  = "SELECT borrow_records.id, books.title, books.image AS image, member.name AS name,
         borrow_records.borrow_date,
         borrow_records.return_date,
          borrow_records.borrow_status,
          borrow_records.return_status,
          books.copies,
          member.email,
          member.phone
        FROM borrow_records 
        JOIN books ON borrow_records.book_id = books.id 
        JOIN member ON borrow_records.member_id = member.id 
        WHERE borrow_status = 'Approved' AND return_status != 'Confirmed'";
// $sql = "SELECT borrow_records.id, books.title, member.name, borrow_records.borrow_date 
//         FROM borrow_records 
//         JOIN books ON borrow_records.book_id = books.id 
//         JOIN member ON borrow_records.member_id = member.id 
//         WHERE borrow_status = 'Pending' AND return_status = 'Pending'";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("فشل إعداد الاستعلام: " . $conn->error);
}

if (!$stmt->execute()) {
    die("فشل تنفيذ الاستعلام: " . $stmt->error);
}

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<h2>طلبات الاسترداد المعلقة</h2><br>";
    echo '<table border="1">
            <tr>
                <th>الصورة</th>
                <th>المعرف</th>
                <th>العضو</th>
                <th>الكتاب</th>
                <th>تاريخ الاستعارة</th>
                <th>الإجراءات</th>
                <th>استرداد</th>
            </tr>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . $row['image'] . '</td>
                <td>' . $row['id'] . '</td>
                <td>' . $row['name'] . '</td>
                <td>' . $row['title'] . '</td>
                <td>' . $row['borrow_date'] . '</td>
                <td>' . $row['borrow_status'] . '</td>
                <td><a href="process_return.php?id=' . $row['id'] . '">تأكيد إسترداد الكتاب</a></td>
              </tr>';
    }
    echo '</table>';
} else {
    echo 'لا توجد طلبات حالياً.';
    echo '<pre>';
    echo "SELECT * FROM borrow_records WHERE borrow_status = 'Pending' AND return_status = 'Pending'";
    echo '</pre>';
}
} else {
    echo 'لا يككنك الوصول الى هذه الصفحة بدون تسجيل الدخول.';
}
?>
