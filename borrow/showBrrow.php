<?php
require_once '../include/session.php';
include '../include/db_connect.php'; // اتصال PDO

// استعلام ملخص الكتب
$sql = "SELECT 
            books.title,
            COUNT(borrow_records.id) AS total_borrow,
            SUM(borrow_records.borrow_status = 'Approved') AS total_borrow_status,
            SUM(borrow_records.return_status = 'Confirmed') AS total_return_status,
            books.copies AS total_copies,
            books.id AS book_id,
            books.image AS image,
            member.name AS member_name,
            borrow_records.borrow_status AS borrow_status,
            borrow_records.return_status AS return_status
        FROM books
        LEFT JOIN borrow_records ON books.id = borrow_records.book_id 
        LEFT JOIN member ON borrow_records.member_id = member.id 
        GROUP BY books.id";

$stmt = $conn->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// بناء الجدول
$summary = "<h1>ملخص الكتب</h1>";
$summary .= "
<table border='1' style='margin:20px auto; text-align:center;'>
    <tr>
        <th>صورة الكتاب</th>
        <th>ID</th>
        <th>عنوان الكتاب</th>
        <th>عدد مرات الاستعارة</th>
        <th>النسخ المتوفرة</th>
        <th>اسم آخر عضو</th>
        <th>حالة الاستعارة</th>
        <th>حالة الاسترجاع</th>
        <th>إجمالي حالات الاستعارة</th>
        <th>إجمالي حالات الاسترجاع</th>
    </tr>
";

if (count($rows) > 0) {
    foreach ($rows as $row) {
        $summary .= "
        <tr>
            <td><img src='{$row['image']}' width='120' height='120'></td>
            <td>{$row['book_id']}</td>
            <td>{$row['title']}</td>
            <td>{$row['total_borrow']}</td>
            <td>{$row['total_copies']}</td>
            <td>{$row['member_name']}</td>
            <td>{$row['borrow_status']}</td>
            <td>{$row['return_status']}</td>
            <td>{$row['total_borrow_status']}</td>
            <td>{$row['total_return_status']}</td>
        </tr>";
    }
} else {
    $summary .= "<tr><td colspan='10'>لا توجد بيانات متاحة.</td></tr>";
}

$summary .= "</table>";

echo $summary;
?>
