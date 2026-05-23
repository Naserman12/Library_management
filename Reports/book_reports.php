<style>
    body{
        margin: 0;
        padding: 0;
        text-align: center;
        background-color: wheat;
        color: #333;
    }
</style>

<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملخص المكتبة</title>
</head>
<body>

<h1>ملخص المكتبة</h1>

<?php
include '../include/db_connect.php';

class Book_reports {

    public $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /* ===================== عدد الكتب المتاحة ===================== */
    public function get_available_books() {
        $sql = "SELECT COUNT(*) AS available_books 
                FROM books 
                WHERE id NOT IN (
                    SELECT book_id FROM borrow_records WHERE return_date IS NULL
                )";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<h3>عدد الكتب المتاحة: {$row['available_books']}</h3><hr>";
    }

    /* ===================== عدد الكتب المستعارة ===================== */
    public function get_borrow_books() {
        $sql = "SELECT COUNT(*) AS borrow_records 
                FROM borrow_records 
                WHERE return_date IS NULL";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<h3>عدد الكتب المستعارة: {$row['borrow_records']}</h3><hr>";
    }

    /* ===================== الكتب الأكثر استعارة ===================== */
    public function get_best_borrow_books() {
        $sql = "SELECT books.title, books.image, 
                       COUNT(borrow_records.book_id) AS borrow_count
                FROM books
                JOIN borrow_records ON books.id = borrow_records.book_id
                GROUP BY books.id
                ORDER BY borrow_count DESC
                LIMIT 5";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h1>الكتب الأكثر استعارة</h1><hr>";

        foreach ($rows as $book) {
            echo "<h3>{$book['title']} - مرات الاستعارة: {$book['borrow_count']}
                  <img src='{$book['image']}' width='100' height='90'></h3><br>";
        }

        echo "<hr>";
    }

    /* ===================== الكتب الأقل استعارة ===================== */
    public function get_low_borrow_books() {
        $sql = "SELECT books.title, 
                       COUNT(borrow_records.book_id) AS borrow_count
                FROM books
                LEFT JOIN borrow_records ON books.id = borrow_records.book_id
                GROUP BY books.id
                ORDER BY borrow_count ASC
                LIMIT 3";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h2>الكتب الأقل استعارة</h2><hr>";

        foreach ($rows as $book) {
            echo "<h3>{$book['title']} - مرات الاستعارة: {$book['borrow_count']}</h3><br>";
        }

        echo "<hr>";
    }

    /* ===================== عدد الأعضاء ===================== */
    public function get_all_members() {
        $sql = "SELECT COUNT(*) AS total_members 
                FROM member 
                WHERE role='members'";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<h3>عدد الأعضاء المسجلين: {$row['total_members']}</h3><hr>";
    }

    /* ===================== الأعضاء الأكثر نشاطًا ===================== */
    public function get_most_active_members() {
        $sql = "SELECT member.name, 
                       COUNT(borrow_records.member_id) AS borrow_count
                FROM member
                JOIN borrow_records ON member.id = borrow_records.member_id
                GROUP BY member.id
                ORDER BY borrow_count DESC
                LIMIT 3";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h1>الأعضاء الأكثر نشاطًا</h1><hr>";

        foreach ($rows as $row) {
            echo "<h3>العضو: {$row['name']} — مرات الاستعارة: {$row['borrow_count']}</h3><br>";
        }

        echo "<hr>";
    }

    /* ===================== الأعضاء الذين لديهم كتب مستعارة ===================== */
    public function get_members_with_borrowed_books() {
        $sql = "SELECT member.name, 
                       COUNT(borrow_records.member_id) AS borrowed_books_count
                FROM member
                JOIN borrow_records ON member.id = borrow_records.member_id
                WHERE borrow_records.return_date IS NULL
                GROUP BY member.id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h1>الأعضاء الذين لديهم كتب مستعارة</h1><hr>";

        foreach ($rows as $row) {
            echo "<h3>{$row['name']} — عدد الكتب: {$row['borrowed_books_count']}</h3><br>";
        }

        echo "<hr>";
    }

    /* ===================== الأعضاء الذين لم يستعيروا أي كتاب ===================== */
    public function get_members_without_borrow() {
        $sql = "SELECT member.name
                FROM member
                LEFT JOIN borrow_records ON member.id = borrow_records.member_id
                WHERE borrow_records.member_id IS NULL";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h1>الأعضاء الذين لم يقوموا بأي استعارة</h1><hr>";

        foreach ($rows as $row) {
            echo "<h3>— {$row['name']}</h3>";
        }

        echo "<hr>";
    }
}

/* ===================== تشغيل التقارير ===================== */

$reports = new Book_reports($conn);

$reports->get_available_books();
$reports->get_borrow_books();
$reports->get_best_borrow_books();
$reports->get_low_borrow_books();
$reports->get_all_members();
$reports->get_most_active_members();
$reports->get_members_with_borrowed_books();
$reports->get_members_without_borrow();
?>

</body>
</html>
