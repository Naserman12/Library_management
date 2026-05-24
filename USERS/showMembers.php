<?php
require_once '../include/session.php';
include_once '../BOOKS/Book.php';

$sql = "SELECT id, name, email, phone, role FROM member";
$result = $conn->query($sql);

if ($result->rowCount() > 0) {
?>
    <div class="content_sec"> 
        <h1>صفحة عرض الأعضاء</h1>

        <table>
            <tr>
                <td>اسم العضو</td>
                <td>البريد الإلكتروني</td>
                <td>رقم التواصل</td>
                <td>الدور</td>
                <td>ترقية</td>
            </tr>

            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['phone']; ?></td>

                    <td>
                        <?= ($row['role'] === 'admin') ? 'مدير' : 'عضو'; ?>
                    </td>

                    <?php if ($row['role'] == 'members') { ?>
                        <td>
                            <a href="../admin/promote.php?id=<?= $row['id']; ?>">ترقية إلى مشرف</a>
                        </td>
                    <?php } else { ?>
                        <td>== مشرف ==</td>
                    <?php } ?>
                </tr>
            <?php } ?>

        </table>
    </div>

<?php
} else {
    echo 'لا يوجد أعضاء';
}
?>

<h3><a href="../Reports/book_reports.php">ملخص المكتبة</a></h3>