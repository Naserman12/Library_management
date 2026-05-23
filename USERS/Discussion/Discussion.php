<?php
require_once __DIR__ . '/../../include/db_connect.php';

class Discussion {
    private $conn;
    private $table = "discussions";

    public function __construct($db){
        $this->conn = $db;
    }

    // حذف مناقشة
    public function deleteDiscussion($id){
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // إنشاء مناقشة جديدة
    public function createDiscussion($title, $memberId, $content){
        $query = "INSERT INTO " . $this->table . " (title, member_id, content, created_at)
                  VALUES (:title, :memberId, :content, NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":memberId", $memberId, PDO::PARAM_INT);
        $stmt->bindParam(":content", $content);

        if ($stmt->execute()) {
            echo "تم إضافة المنشور بنجاح";
            header("REFRESH:2; URL=Add_discussion.php");
        } else {
            echo "حدث خطأ أثناء إضافة المنشور";
        }
    }

    // جلب المناقشة + التعليقات
    public function getDiscussionWithComments($discussion_id){

        // جلب جميع المناقشات
        $query = "SELECT d.id, d.title, d.content, d.created_at, m.name
                  FROM discussions d
                  JOIN member m ON d.member_id = m.id
                  ORDER BY d.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $discussions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // جلب مناقشة واحدة
        $query = "SELECT d.id, d.title, d.content, d.created_at, m.name
                  FROM discussions d
                  JOIN member m ON d.member_id = m.id
                  WHERE d.id = ?
                  ORDER BY d.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $discussion_id, PDO::PARAM_INT);
        $stmt->execute();
        $discussion = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // جلب التعليقات
        $query = "SELECT c.content, c.created_at, m.name
                  FROM discussion_comments c
                  JOIN member m ON c.member_id = m.id
                  WHERE c.discussion_id = ?
                  ORDER BY c.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $discussion_id, PDO::PARAM_INT);
        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'discussions' => $discussions,
            'discussion'  => $discussion,
            'comments'    => $comments
        ];
    }
}
class Comments {
    private $conn;
    private $table = "discussion_comments";

    public function __construct($db){
        $this->conn = $db;
    }

    public function addComment($discussion_id, $memberId, $content){
        if (empty($content)) {
            return "محتوى التعليق لا يمكن أن يكون فارغًا.";
        }

        $query = "INSERT INTO " . $this->table . " (discussion_id, member_id, content, created_at)
                  VALUES (:discussion_id, :memberId, :content, NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":discussion_id", $discussion_id, PDO::PARAM_INT);
        $stmt->bindParam(":memberId", $memberId, PDO::PARAM_INT);
        $stmt->bindParam(":content", $content);

        if ($stmt->execute()) {
            echo "تم إضافة التعليق بنجاح";
            header("REFRESH:2; URL=showDiscussions.php");
        } else {
            echo "حدث خطأ أثناء إضافة التعليق";
        }
    }

    public function showComments($bookId){
        $query = "SELECT * FROM comments WHERE book_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $bookId, PDO::PARAM_INT);
        $stmt->execute();

        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h3>التعليقات</h3>";

        if (!empty($comments)) {
            foreach ($comments as $comment) {
                echo "<p>{$comment['comment']}</p>";
                echo "<p><strong>التقييم:</strong> {$comment['rating']}/5</p>";
                echo "<hr>";
            }
        } else {
            echo "لا توجد تعليقات.";
        }
    }
}
