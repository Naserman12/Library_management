<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام التعليقات</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
        }
        .comments-section {
            width: 80%;
            max-width: 600px;
            margin: 20px 0;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .comment {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .comment:last-child {
            border-bottom: none;
        }
        .comment .comment-author {
            font-weight: bold;
            color: #555;
        }
        .comment .comment-date {
            font-size: 0.9em;
            color: #999;
            margin-top: 5px;
        }
        .comment .comment-content {
            margin-top: 10px;
            line-height: 1.6;
        }
        .add-comment {
            margin-top: 20px;
        }
        .add-comment textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            resize: vertical;
            font-size: 1em;
        }
        .add-comment button {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            margin-top: 10px;
        }
        .add-comment button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT']. '/library/include/db_connect.php';
        require_once "Discussion.php";

        session_start();
        if(!isset($_GET['id'])){
            echo "لم يتم تحديد معرف المشاركة!.";
                return 0;
            }
            $Discussion_id = $_GET['id'];
            $Discussion = new Discussion($conn);
            $comment = new Comments($conn);
            $result = $Discussion->getDiscussionWithComments($Discussion_id);
            $discussions = $result['discussion'];
            $comments = $result['comments'];
            // echo $discussion['id'];
                ?>
    <?php foreach($discussions as $discussion): ?>
   <div class="discussion-detail"> 
       <h2><?= htmlspecialchars($discussion['title']) ?></h2>
       <p>نشر بواسطة: <?= htmlspecialchars($discussion['name']) ?> في <?= htmlspecialchars($discussion['created_at']) ?></p>
       <p><?= nl2br(htmlspecialchars($discussion['content'])) ?></p>
       <?php endforeach; ?>
       <div class="comments-section">
           <h2>التعليقات</h2>
                <?php if($comments): ?>
                    <!-- عرض التعليقات -->  
                    <div class="comment">
                        <?php foreach($comments as $comment): ?>
                            <div class="comment-author"><?php echo htmlspecialchars($comment['name'] ?? "بدون عنوان") ?></div>
                            <div class="comment-date"><?php echo htmlspecialchars($comment['created_at']); ?></div>
                        <div class="comment-content"><?= htmlspecialchars($comment['content'] ?? "لا تعليق"); ?></div>
                        <?php endforeach; else: echo " <div class='comment-author'>لا توجد تعليقات</div>"; endif;  ?>
                    </div>
                <!-- إضافة تعليق جديد -->
                <div class="add-comment">
                    <h3>أضف تعليقك</h3>
                        <form method="POST" action="add_comment.php">
                            <?php if (isset($_SESSION['memberId'])) { ?>
                            <textarea name="comment_content" placeholder="اكتب تعليقك هنا..." required></textarea>
                            <input type="hidden" name="discussion_id" value="<?= $discussion['id']; ?>">
                            <button type="submit">إرسال</button>
                        </form>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php 
}else{ echo 'سجل دخول لاضافة التعليق!.<br>'; } ?>
