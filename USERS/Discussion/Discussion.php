<?php
   require_once $_SERVER['DOCUMENT_ROOT']. '/library/include/db_connect.php';
//    <--===========كلاس المناقشات=========-->
class Discussion{
    private $conn;
    private $table = "discussions";
    public function __construct($db){
        $this->conn = $db;

    }
          //   <--------حذف--------->
          public function deleteDiscussion($id){
            $query = "DELETE FROM ". $this->table ." WHERE id=?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                // die ("Error in prepare statement: ".$this->conn->error);
               return true;
            }else{
                return false;
            }
            // return $stmt->execute();
          }
        //   <--//------حذف-------//-->
    
public function createDiscussion( $title, $memberId, $content){
    // تنظيف البيانات المدخلة لتجنب SQL Injection
    // $discussion_id = $this->conn->real_escape_string($discussion_id);
    $title = $this->conn->real_escape_string($title);
    $memberId = $this->conn->real_escape_string($memberId);
    $content = $this->conn->real_escape_string($content);

   $sql = "INSERT INTO ".$this->table." (title, member_id, content, created_at) VALUES ('$title', $memberId,  '$content', NOW())";
//    echo "<pre>";
//    var_dump($sql);
//    echo "</pre>";

   if ($this->conn->query($sql) === TRUE) {
       echo "تم إضافة التعليق بنجاح";
       header( "REFRESH:3; URL = Add_discussion.php");
   } else {
    echo "لقد حدث خطأ لم يتم إضافة المنشور.";
    //    echo "خطأ: " . $sql . "<br>" . $this->conn->error;
   }
   
   // إغلاق الاتصال
   // $this->conn->close();
}
// جلب مناقشة بتعليقاتها
public function getDiscussionWithComments($discussion_id) {
    // جلب تفاصيل المناقشة
    $discussion_query = "SELECT discussions.id, discussions.title, discussions.content, discussions.created_at, member.name
                        FROM discussions
                        JOIN member ON discussions.member_id = member.id
                        ORDER BY discussions.created_at DESC";
    $discussion_result = mysqli_query($this->conn,  $discussion_query);
    // var_dump($discussion_result);
    $discussions = mysqli_fetch_All($discussion_result, MYSQLI_ASSOC );

        // جلب تفاصيل المناقشة حسب المعرف
        $discussion_query = "SELECT discussions.id, discussions.title, discussions.content, discussions.created_at, member.name
        FROM discussions
        JOIN member ON discussions.member_id = member.id
        WHERE discussions.id = $discussion_id
        ORDER BY discussions.created_at DESC";
        $discussion_result = mysqli_query($this->conn,  $discussion_query);
        // var_dump($discussion_result);
        $discussion = mysqli_fetch_All($discussion_result, MYSQLI_ASSOC );
    
    // جلب التعليقات المرتبطة
    
        $comments_query = "   SELECT discussion_comments.content, discussion_comments.created_at, member.name 
                                FROM discussion_comments 
                                JOIN member ON discussion_comments.member_id = member.id 
                                WHERE discussion_comments.discussion_id = $discussion_id
                                ORDER BY discussion_comments.created_at DESC
                                ";
        $comments_result = mysqli_query($this->conn,  $comments_query);
        if ($comments_result && mysqli_num_rows($comments_result) > 0) {
            $comments = mysqli_fetch_All($comments_result, MYSQLI_ASSOC); // جلب بيانات المناقشة
        } else {
            $comments = []; // تعيين مصفوفة فارغة في حال عدم وجود تعليقات
        }

    return ['discussions' => $discussions, 'discussion' => $discussion, 'comments' => $comments ];
}
}
//    <//--===========كلاس المناقشات=========--//>
// <--======كلاس التعليقات على المناقشات=====-->
class Comments{
    private $conn;
    private $table = "discussion_comments";
    
    public function __construct($db){
        $this->conn = $db;
}


public function addComment($discussion_id,$memberId, $content){
    if (empty($content)) {
        return "محتوى التعليق لا يمكن أن يكون فارغًا.";
    }
     // تنظيف البيانات المدخلة لتجنب SQL Injection
     $discussion_id = $this->conn->real_escape_string($discussion_id);
     $memberId = $this->conn->real_escape_string($memberId);
     $content = $this->conn->real_escape_string($content);
    $sql = "INSERT INTO ".$this->table." (discussion_id, member_id, content, created_at) VALUES ($discussion_id, $memberId, '$content', NOW())";

    if ($this->conn->query($sql) === TRUE) {
        echo "تم إضافة التعليق بنجاح";
        header( "REFRESH:3; URL = showDiscussions.php");
    }else{
        echo "خطأ: " . $sql . "<br>" . $this->conn->error;
    }
    
    // إغلاق الاتصال
    // $this->conn->close();
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

}
// <//--======كلاس التعليقات  على الناقشات=====--//>
?>