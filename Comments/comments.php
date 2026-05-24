<?php
require_once '../include/session.php';
require_once '../include/db_connect.php';

class Comments
{
    public $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // =========================================
    // عرض التعليقات
    // =========================================
    public function getComments($bookId)
    {
        $sql = "SELECT c.comment, c.created_at, m.name
                FROM comments c
                JOIN member m ON c.member_id = m.id
                WHERE c.book_id = :book_id
                ORDER BY c.created_at DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':book_id' => $bookId
        ]);

        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($comments) > 0) {

            foreach ($comments as $row) {

                echo "<p>
                        <strong>" . htmlspecialchars($row['name']) . ":</strong>
                        " . htmlspecialchars($row['comment']) . "
                        <em>في " . $row['created_at'] . "</em>
                      </p>";
            }

        } else {

            echo "لا توجد تعليقات.";
        }
    }

    // =========================================
    // إضافة تعليق
    // =========================================
    public function addComment($bookId, $memberId, $comment, $rating)
    {
        try {

            $sql = "INSERT INTO comments
                    (book_id, member_id, comment, rating, created_at)
                    VALUES
                    (:book_id, :member_id, :comment, :rating, NOW())";

            $stmt = $this->conn->prepare($sql);

            $result = $stmt->execute([
                ':book_id' => $bookId,
                ':member_id' => $memberId,
                ':comment' => $comment,
                ':rating' => $rating
            ]);

            if ($result) {

                echo "تم إضافة التعليق بنجاح";

                header("Refresh:2; url=../BOOKS/home.php");
                exit;

            } else {

                echo "حدث خطأ أثناء إضافة التعليق";
            }

        } catch (PDOException $e) {

            echo "خطأ: " . $e->getMessage();
        }
    }

    // =========================================
    // عرض تفاصيل الكتاب
    // =========================================
    public function showDetils($bookId)
    {
        $sql = "SELECT * FROM books WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':id' => $bookId
        ]);

        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($book) {

            echo '<h2>' . htmlspecialchars($book['title']) . '</h2><br>';

            echo '<img src="' . htmlspecialchars($book['image']) . '" width="150" height="150"><br>';

            echo '<h2>' . htmlspecialchars($book['detil']) . '</h2><br>';

        } else {

            echo "الكتاب غير موجود";
        }
    }

    // =========================================
    // عرض التعليقات الخاصة بالكتاب
    // =========================================
    public function showComments($bookId)
    {
        $sql = "SELECT * FROM comments
                WHERE book_id = :book_id
                ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':book_id' => $bookId
        ]);

        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h3>التعليقات</h3>";

        if (count($comments) > 0) {

            foreach ($comments as $comment) {

                echo "<p>" . htmlspecialchars($comment['comment']) . "</p>";

                echo "<p><strong>التقييم:</strong> "
                    . htmlspecialchars($comment['rating']) .
                    "/5</p>";

                echo "<hr>";
            }

        } else {

            echo "لا توجد تعليقات.";
        }
    }

    // =========================================
    // متوسط التقييم
    // =========================================
    public function averageRaing($bookId)
    {
        $sql = "SELECT AVG(rating) AS avg_rating
                FROM comments
                WHERE book_id = :book_id";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':book_id' => $bookId
        ]);

        $avg = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($avg && $avg['avg_rating'] !== null) {

            echo "<p>متوسط التقييم: "
                . round($avg['avg_rating'], 1)
                . "/5</p>";

        } else {

            echo "<p>لا يوجد تقييمات بعد.</p>";
        }
    }
}

?>