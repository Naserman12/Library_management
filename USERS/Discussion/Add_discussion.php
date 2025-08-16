<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/library/include/db_connect.php';
require_once "Discussion.php";
session_start();
    if ($_SESSION['role'] === 'admin') {
    echo "يكمنك المشاركة!!";
    $discussion = new  Discussion($conn);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        $title = $_POST['title'];
        $memberId = $_SESSION['memberId'];
        $content = $_POST['content'];
        $discussion->createDiscussion($title, $memberId, $content);
    }
    $discussion_id = 0;
    $result = $discussion->getDiscussionWithComments(    $discussion_id);
    $discussions = $result['discussions'];
    ?>
<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
 .del_btn{
    text-decoration: none;
  background-color: rgb(218, 19, 19);
  color: white;
  font-size: 20px;
  padding: 8px 18px;
  border-radius: 2px;
  border-radius: 10px;
  border: 1px solid rgb(56, 55, 55);
  margin-right: 5px;
}
.del_btn:hover{
    background-color: #580f0f;
}
    </style>
    <title>أضافة مناقشة</title>
</head>
<body>
    <main>
        <h2>إضافة مناقشة</h2>
        <form action="" method="POST">
            <label for="">العنوان</label>
            <input type="text" name="title">
            <label for="">المحتوى</label>
            <textarea name="content" placeholder="اكتب تعليقك هنا..." required></textarea>
            <!-- <input type="textarea" name="content"> -->
            <button type="submit" >إضافة</button>
        </form><br><hr><br>
        <div class="discussions-list">
    <h2>المناقشات</h2>
    <?php foreach ($discussions as $discussion): ?>
        <div class="discussion-post">
            <h3><a style="text-decoration: none; color:black;" href="showDiscusstionDitels.php?id=<?= $discussion['id'] ?>"><?= htmlspecialchars($discussion['title']) ?></a></h3>
            <p>نشر بواسطة: <?= htmlspecialchars($discussion['name']) ?> في <?= htmlspecialchars($discussion['created_at']) ?></p>
            <p>محتوى: <?= substr(htmlspecialchars($discussion['content']), 0, 50) ?>...</p>
            <a style="text-decoration: none;" href="showDiscusstionDitels.php?id=<?= $discussion['id'] ?>">اقرأ المزيد</a>
        </div><br>
        <!-- <td><a href="<?php echo $discussion['id']; ?>"><i class="fa-solid fa-edit"></i>تعديل</a></td> -->
        <td><a  class="del_btn" onclick="return confirm('هل انت تريد حذف التصنيف؟؟.')"  href="delDiscussion.php?id=<?php echo $discussion['id']; ?>">حذف</a></td><br><br>
    <?php endforeach; ?>
</div>
    </main>
</body>
</html>
<?php
}else{
    echo "لا يمكنك الوصول لهذه الصفحة !!.";
    header( "REFRESH:3; URL = ../../BOOKS/home.php");
}