<?php
require_once "../file/head.php";
?>
<title>تفاصيل الكتاب</title>

<style>
/* الحاوية الرئيسية */
.showBooksContainer {
    max-width: 800px;
    margin: 50px auto; /* توسيط الحاوية */
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    text-align: center; /* توسيط النص */
    direction: rtl; /* اتجاه عربي */
    font-family: "Tajawal", sans-serif;
}

/* العنوان */
.showBooksContainer h1 {
    margin-bottom: 20px;
    color: #333;
}

/* زر الاستعارة */
.add_to_cart {
    display: inline-block;
    background: #3498db;
    color: #fff;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 16px;
    transition: background 0.3s ease;
    margin: 8px auto;
    width: 300px;
}

.add_to_cart:hover {
    background: #2980b9;
}

/* زر إضافة تعليق */
.showBooksContainer a[href*="addCom"] {
    display: inline-block;
    margin-top: 5px;
    background: #2ecc71;
    color: #fff;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 15px;
    width: 300px;
}

.showBooksContainer a[href*="addCom"]:hover {
    background: #27ae60;
}

/* قسم التعليقات */
.comments-section {
    margin-top: 30px;
    text-align: left;
    direction: rtl;
}
</style>

<div class="showBooksContainer">
    <h1>عرض تفاصيل الكتاب</h1>
    <?php
    require_once 'comments.php';
    $book = new Book($conn);
    $comment = new Comments($conn);
    $book_id = $_GET['book_id'];
    $book = $book->getBook($book_id);
    $comm1 = $comment->showDetils($book_id);
    $comm2 = $comment->averageRaing($book_id);
    ?>
    <!-- زر الاستعارة -->
    <div class="submit">
        <?php if(isset($_SESSION['memberId'])): if($book['copies'] > 0){ ?>
            <a class="add_to_cart" href="../borrow/Borrow.php?id=<?= $book['id']; ?>"> استعارة الكتاب</a>
        <?php } else { ?>
            <a class="add_to_cart" onclick="return confirm('الكتاب غير متوفر')" href="#"> استعارة الكتاب</a>
        <?php } else: ?>
            <a class="add_to_cart" onclick="return confirm('يجب تسجيل الدخول أولا.')" href="../admin/login.php"> استعارة الكتاب</a>
        <?php endif; ?>
    </div>
    <!--// زر الاستعارة //-->

    <!-- عرض التعليقات -->
    <div class="comments-section">
        <?php $comment->showComments($book_id); ?>
    </div>
    <!-- زر إضافة تعليق -->
    <a href="addCom.php?book_id=<?= $book_id; ?>">✍️ إضافة تعليق</a>
</div>

<?php
require_once "../file/footer.php";
?>
