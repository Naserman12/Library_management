<?php
require_once '../include/session.php';
include '../include/db_connect.php'; // اتصال PDO

if (!isset($_SESSION['memberId'])) {
    echo 'لا يمكنك الوصول إلى هذه الصفحة بدون تسجيل الدخول.';
    exit;
}

// استعلام جلب الطلبات المعلقة
$sql = "SELECT borrow_records.id, books.title, books.image AS image, member.name AS name,
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

$stmt = $conn->prepare($sql);
$stmt->execute();

// جلب النتائج
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($rows) > 0) {
    echo "<h2>طلبات الاسترداد المعلقة</h2><br>";

    echo '<table border="1" style="margin: 10px auto; text-align:center;">
            <tr>
                <th>الصورة</th>
                <th>المعرف</th>
                <th>العضو</th>
                <th>الكتاب</th>
                <th>تاريخ الاستعارة</th>
                <th>الحالة</th>
                <th>استرداد</th>
            </tr>';

    foreach ($rows as $row) {
        echo "<tr>
                <td><img src='{$row['image']}' width='120' height='120'></td>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['title']}</td>
                <td>{$row['borrow_date']}</td>
                <td>{$row['borrow_status']}</td>
                <td><a href='process_return.php?id={$row['id']}'>تأكيد استرداد الكتاب</a></td>
              </tr>";
    }

    echo '</table>';

} else {
    echo 'لا توجد طلبات حالياً.';
}
?>
