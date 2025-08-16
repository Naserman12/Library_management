<?php
include '../include/db_connect.php';

class Comments{
    public $conn;
    public function __construct($db){
        $this->conn = $db;
}
public function getComments($bookId){
    $sql = "SELECT c.comment, c.created_at, m.name 
    FROM comments c 
    JOIN member m ON c.member_id = m.id 
    WHERE c.book_id = '$bookId' 
    ORDER BY c.created_at DESC";
    $result = $this->conn->query($sql);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<p><strong>" . htmlspecialchars($row['name']) . ":</strong> " .htmlspecialchars($row['comment']) ." <em>في " . $row['created_at'] . "</em></p>";

        }
    }else{
        echo "لا توجد تعليقات. ";
    }
}

public function addComment($bookId, $memberId, $comment, $rating){
     // تنظيف البيانات المدخلة لتجنب SQL Injection
     $bookId = $this->conn->real_escape_string($bookId);
     $memberId = $this->conn->real_escape_string($memberId);
     $comment = $this->conn->real_escape_string($comment);

    $sql = "INSERT INTO comments (book_id, member_id, comment, rating, created_at) VALUES ('$bookId', '$memberId', '$comment', '$rating', NOW())";

    if ($this->conn->query($sql) === TRUE) {
        echo "تم إضافة التعليق بنجاح";
        header( "REFRESH:3; URL = ../BOOKS/home.php");
    } else {
            echo "لقد حدث خطأ ولم يتم اضافة التعليق";
        // echo "خطأ: " . $sql . "<br>" . $this->conn->error;
    }
    
    // إغلاق الاتصال
    // $this->conn->close();
}
public function showDetils($bookId){
    // جلب تفاصيل الكتاب
    $bookQuery = "SELECT * FROM books WHERE id = $bookId";
    $book_result = mysqli_query($this->conn, $bookQuery); 
    $book = mysqli_fetch_assoc($book_result);
    if ($book) {
        echo'<h2>'. $book['title']. '</h2><br>';
        echo ' <img src="'.$book['image'] .'" alt="" width="150" height="150"> ';
        echo '<h2>'. $book['detil'] . '</h2><br>';  
    }else{
        return 0;
    }
}
public function showComments($bookId){
    // $bookId = $_GET['book_id'];
    // جلب التعليقات المرتبطة بالكتاب
    $comments_Query = "SELECT * FROM comments WHERE book_id = $bookId";
    $comments_result = mysqli_query($this->conn, $comments_Query);
            ?>
           
            <h3>التعليقات</h3>
            <?php if(mysqli_fetch_assoc($comments_result)): ?>
            <?php while($comment = mysqli_fetch_assoc($comments_result)): ?>
                <p><?php echo $comment['comment']; ?></p>
            <p><strong>القييم:</strong> <?php echo $comment['rating'];?>/5</p>
            <hr>
            <?php endwhile; else: echo 'لا توجد تعليقات.';  endif;  ?>
            <?php
}
public function averageRaing($book_id){
    $avgQuery = "SELECT AVG(rating) AS avg_rating FROM comments WHERE book_id = $book_id";
    $avgResult = mysqli_query($this->conn, $avgQuery);
    if ($avgResult) {
    $avg = mysqli_fetch_assoc($avgResult);
    ?>
    <p>متوسط التقييم: <?php echo round($avg['avg_rating'], 1); ?>/5</p>
    <?php
    }else{
        // echo 'لم يتم تحديد على المعرف';
        return 0;
    }
    
}

}
// $bookId = 1;
// $memberId =14;
// $comment = "اتمنى ان اقرا هذا الكتاب . ";
// $rating = 4;
// $comments = new Comments($conn);
// $comments->addComment($bookId, $memberId, $comment, $rating);
// $comments->getComments($bookId);
// $comments->showDetils($bookId);
// $comments->averageRaing($bookId);
// $comments->showComments($bookId);

?>