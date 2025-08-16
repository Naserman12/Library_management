<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/library/include/db_connect.php';
require_once "Discussion.php";
session_start();
// if (isset($_SESSION['memberId'])) {
    $discussion_id = 0;
    $Discussion = new Discussion($conn);
     $result = $Discussion->getDiscussionWithComments($discussion_id);
     $discussions = $result['discussions'];
?>

<style>
    /* تصميم واجهة عرض المناقشات */
.discussions-list {
    margin: 20px;
}

.discussion-post {
    border-bottom: 1px solid #ccc;
    padding: 15px 0;
}

.discussion-post h3 {
    font-size: 1.5em;
}

.discussion-post a {
    color: #007BFF;
    text-decoration: none;
}

.discussion-post a:hover {
    text-decoration: underline;
}
</style>
<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مناقشات</title>
</head>
<body>
<div class="discussions-list">
    <h2>المناقشات</h2>
    <?php foreach ($discussions as $discussion): ?>
        <div class="discussion-post">
            <h3><a href="showDiscusstionDitels.php?id=<?= $discussion['id'] ?>"><?= htmlspecialchars($discussion['title']) ?></a></h3>
            <p>نشر بواسطة: <?= htmlspecialchars($discussion['name']) ?> في <?= htmlspecialchars($discussion['created_at']) ?></p>
            <p>محتوى: <?= substr(htmlspecialchars($discussion['content']), 0, 50) ?>...</p>
            <a href="showDiscusstionDitels.php?id=<?= $discussion['id'] ?>">اقرأ المزيد</a>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>