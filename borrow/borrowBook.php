<?php
session_start();
include '../USERS/MemberClass.php';

// $borrowRequests = new Member($conn);
// <!-- استدعاء دالة جلب الطلبات التي قيد الانتظار-->
$sql = "SELECT borrow_records.id, books.title, books.image, member.name, borrow_records.borrow_date 
FROM borrow_records 
JOIN books ON borrow_records.book_id = books.id 
JOIN member ON borrow_records.member_id = member.id 
WHERE borrow_status = 'Pending' AND return_status = 'Pending'";
$stmt = $conn->prepare($sql);
// echo $sql;
if(!$stmt){
    die("فشل اعداد الاستعلام". $conn->error);
}

if (!$stmt->execute()) {
    echo "فشل تنفيذ الاستعلام". $stmt->error;
}

$stmt->execute();

     $result = $stmt->get_result();
// var_dump($result) ;
if($result->num_rows > 0) {
    echo "<h2>طلبات الاستعارة المعلقة</h2><br>";
     while ($row = $result->fetch_assoc()){
        ?>
       
 <table border="1">
     <tr>
        <th>الصورة</th>
    <th>العضو</th>
    <th>الكتاب</th>
    <th>تاريخ الاستعارة</th>
    <th>الاجراءات</th>
   </tr>
 
       <tr>
        <td><img src="<?php echo $row['image']; ?>" alt="" width="120" height="120"></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['borrow_date']; ?></td>
        <td>
        <a href="process_borrow.php?id=<?php echo $row['id']; ?>&action=approve">قبول</a>|
        <a href="process_borrow.php?id=<?php echo $row['id']; ?>&action=reject">رفض</a>
        </td>
        </tr>
        </table>
        <?php
    } 
    }else{
    echo 'لا توجد طلبات حاليا.';
    }
    $conn->close();

    ?>

        <!-- // SELECT * FROM borrow_records WHERE borrow_status =  'Approved' AND return_status = 'Pending' -->

