<?php
require_once "../file/head.php";

if(isset($_SESSION["memberId"])){
    require_once "../showNews.php";
    // var_dump($_SESSION);
}else{
    echo '<h3>سجل دخول لتتمكن من استعارة الكتب والمزيد!!<br></h3>';
}

/* =========================
   🔧 1. تعديل البحث هنا
   ========================= */
$book = new Book($conn);
$category = new category($conn);

$searchTerm = $seachTerm ?? null;

if (!empty($searchTerm)) {
    $books = $book->searchBooks($searchTerm);
} else {
    $books = $book->getBooks();
}

?>

<h2 style="color:black; text-decoration:none; text-align:center; margin:8px;" dir="rtl">
    <a href="../DigiBooks/showDigiBooks.php">|الكتب الإلكترونية|</a>
</h2>

<?php
/* =========================
   🔧 2. إزالة mysqli_num_rows بالكامل
   ========================= */

if (!empty($books)) {
?>

<main>
    <?php
require_once '../include/flash.php';

$flash = getFlash();

if ($flash) {
    echo "<div class='{$flash['type']}'>{$flash['message']}</div>";
}
    ?>
    <?php if (!empty($searchTerm)): ?>
        <h2>نتائج البحث</h2>
    <?php endif; ?>

    <?php foreach($books as $book): ?>

    <div class="product">

        <div class="product_img">
            <a href="../Comments/showBookDetiles.php?book_id=<?php echo $book['id']; ?>">
                <img src="<?php echo $book['image'] ?? ''; ?>" alt="صورة الكتاب">
            </a>

            <span class="unvailable">
                <?php
                if ($book['copies'] >= 5) {
                    echo 'متوفر';
                } elseif ($book['copies'] > 0) {
                    echo 'متوفر بكمية';
                } else {
                    echo 'غير متوفر';
                }
                ?>
            </span>
        </div>

        <div class="product_section">
            <a href=""><?php echo $book['author']; ?></a>
        </div>

        <div class="product_name">
            <a href=""><?php echo $book['title']; ?></a>
        </div>

        <div class="product_price">
            <p>💰 السعر: <?= $dailyPrice ?? 4 ?> ريال / يومياً</p>
        </div>

        <div class="date">
            <a href=""><?php echo $book['year']; ?> :سنة النشر</a>
        </div>

        <div class="product_description">
            <a href="">
                <i class="fa-solid fa-eye"></i>
                <?php echo $book['copies']; ?> :عدد النسخ
            </a>
        </div>

        <div class="submit">

            <?php if(isset($_SESSION['memberId'])): ?>

                <?php if($book['copies'] > 0): ?>
                    <a class="add_to_cart" href="../borrow/Borrow.php?id=<?php echo $book['id']; ?>">
                        استعارة الكتاب
                    </a>
                <?php else: ?>
                    <a class="add_to_cart" onclick="return confirm('الكتاب غير متوفر')" href="#">
                        استعارة الكتاب
                    </a>
                <?php endif; ?>

            <?php else: ?>
                <a class="add_to_cart" onclick="return confirm('يجب تسجيل الدخول أولا.')" href="../admin/login.php">
                    استعارة الكتاب
                </a>
            <?php endif; ?>

        </div>

    </div>

    <?php endforeach; ?>

</main>

<?php
} else {

    echo '<h2>جميع الكتب</h2>';

    $allBooks = $book->getBooks();

    if (!empty($allBooks)) {
?>

<main>

    <?php foreach ($allBooks as $book): ?>

    <div class="product">

        <div class="product_img">
            <img src="<?php echo $book['image']; ?>" alt="">
        </div>

        <div class="product_section">
            <a href=""><?php echo $book['author']; ?></a>
        </div>

        <div class="product_name">
            <a href=""><?php echo $book['title']; ?></a>
        </div>

        <div class="product_price">
            <a href=""><?php echo $book['year']; ?> :سنة النشر</a>
        </div>

        <div class="product_description">
            <a href="">
                <i class="fa-solid fa-eye"></i>
                <?php echo $book['copies']; ?> :عدد النسخ
            </a>
        </div>

        <div class="submit">

            <?php if(isset($_SESSION['memberId'])): ?>

                <?php if($book['copies'] > 0): ?>
                    <a class="add_to_cart" href="../borrow/Borrow.php?id=<?php echo $book['id']; ?>">
                        استعارة الكتاب
                    </a>
                <?php else: ?>
                    <span>غير متوفر</span>
                <?php endif; ?>

            <?php else: ?>
                <a class="add_to_cart" onclick="return confirm('يجب تسجيل الدخول أولا.')" href="../admin/login.php">
                    استعارة الكتاب
                </a>
            <?php endif; ?>

        </div>

    </div>

    <?php endforeach; ?>

</main>

<?php
    } else {
        echo "لا توجد كتب لعرضها";
    }
}
?>

<a href="../process_request.php">ملاحظات ||</a>
<a href="../USERS/Discussion/showDiscussions.php">المناقشات..</a>

<?php include ("../file/footer.php"); ?>