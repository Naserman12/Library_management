<?php
require_once '../include/session.php';
include '../include/db_connect.php'; // يحتوي على اتصال PDO

// جلب الطلبات المعلقة
$sql = "SELECT borrow_records.id, books.title, books.image, member.name, borrow_records.borrow_date 
        FROM borrow_records 
        JOIN books ON borrow_records.book_id = books.id 
        JOIN member ON borrow_records.member_id = member.id 
        WHERE borrow_status = 'Pending' AND return_status = 'Pending'";

$stmt = $conn->prepare($sql);
$stmt->execute();

// جلب النتائج
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($rows) > 0) {
    echo "<h2>طلبات الاستعارة المعلقة</h2><br>";

    echo '<table border="1" style="margin: 10px auto; text-align:center;">';
    echo '<tr>
            <th>الصورة</th>
            <th>العضو</th>
            <th>الكتاب</th>
            <th>تاريخ الاستعارة</th>
            <th>الإجراءات</th>
          </tr>';

    foreach ($rows as $row) {
        echo "<tr>
                <td><img src='{$row['image']}' width='120' height='120'></td>
                <td>{$row['name']}</td>
                <td>{$row['title']}</td>
                <td>{$row['borrow_date']}</td>
                <td>
                    <a href='process_borrow.php?id={$row['id']}&action=approve'>قبول</a> |
                    <a href='process_borrow.php?id={$row['id']}&action=reject'>رفض</a>
                </td>
              </tr>";
    }

    echo "</table>";

} else {
    echo "<h3>لا توجد طلبات حاليا.</h3>";
}
?>
