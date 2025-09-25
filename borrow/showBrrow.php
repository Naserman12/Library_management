<?php
include '../USERS/MemberClass.php';

// إعداد استعلام جلب الطلبات المعلقة
$sql  = "SELECT books.title,
        COUNT(borrow_records.id) AS total_borrow,
        COUNT(borrow_records.borrow_status) AS total_borrow_status,
        COUNT(borrow_records.return_status) AS total_return_status,
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
// echo $sql;
$result = $conn->query($sql);
$summary = "<h1>ملخص الكتب </h1>";
$summary .= "<table border='1'

        <tr>
        <th>صورة الكتاب</th>
        <th>id</th>
        <th>عنوان الكتاب</th>
        <th>عدد النسخ المستعارة</th>
        <th>النسخ المتوفرة</th>
        <th>اسم العضو</th>
        <th>حالة الاستعارة</th>
        <th>حالة الاسترجاع</th>
        <th>حالة الاسترجاع</th>
        <th>حالة الاسترجاع</th>
        </tr>

";
if ($result->num_rows > 0) {
    
    while ($row = $result->fetch_assoc()) {
        $summary .= '<tr>
        <td><img src="'.$row['image'].'" alt="صورة الكتاب" width="150" height="150"></td>
                       <td>'.$row['book_id'].'</td>
                       <td>'.$row['title'].'</td>
                       <td>'.$row['total_borrow'].'</td>
                       <td>'.$row['total_copies'].'</td>
                       <td>'.$row['member_name'].'</td>
                       <td>'.$row['borrow_status'].'</td>
                       <td>'.$row['return_status'].'</td>
                       <td>'.$row['total_borrow_status'].'</td>
                       <td>'.$row['total_return_status'].'</td>
                    </tr>';
                }
            }else{
            $summary .= "<tr><td colspan='1'>لا توجد بيانات متاحة.</td></tr>";
            }
           $summary .= "</table>";
        echo $summary;
?>
<br><br><br>
