<?php
session_start();
include '../USERS/MemberClass.php';
// التحقق من الكتاب
if (!isset($_GET['id'])) {
    die("⚠️ لم يتم تحديد الكتاب");
}
$book_id = intval($_GET['id']);
$member_id = $_SESSION['memberId'] ?? null;

$bookObj = new Book($conn);
$book = $bookObj->getBook($book_id);

if (!$book) {
    die("⚠️ الكتاب غير موجود");
}

$dailyPrice = $book['price']; // السعر باليوم
$maxDays = 10;   // الحد الأقصى للأيام
// حساب التواريخ عند اختيار الأيام
$borrowDays = $_POST['days'] ?? null;
$borrowDate = date("Y-m-d"); // تاريخ الاستعارة (اليوم)
$returnDate = null;
$totalPrice = null;
$discountedPrice = null;
if ($borrowDays) {
    $returnDate = date("Y-m-d", strtotime("+$borrowDays days"));
    $totalPrice = $borrowDays * $dailyPrice;
    $discountedPrice = $totalPrice - ($totalPrice * 0.10); // خصم 10%
}
?>
<style>
.borrowContainer {
    max-width: 600px;
    margin: 50px auto;
    padding: 30px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    text-align: center;
    direction: rtl;
    color: black;
    font-family: "Tajawal", sans-serif;
}
.borrowContainer img {
    max-width: 150px;
    border-radius: 8px;
    margin-bottom: 15px;
}
.borrowContainer h2 {
    margin: 10px 0;
    color: #333;
}
.borrowContainer p {
    margin: 5px 0;
}
.borrowContainer form {
    margin-top: 20px;
}
.borrowContainer select, .borrowContainer button {
    padding: 10px;
    font-size: 15px;
    margin: 5px;
    border-radius: 6px;
}
.borrowContainer button {
    background: #3498db;
    color: #fff;
    border: none;
    cursor: pointer;
}
.borrowContainer button:hover {
    background: #2980b9;
}
.resultBox {
    margin-top: 20px;
    padding: 15px;
    background: #f8f9fa;
    border: 1px solid #ddd;
    border-radius: 8px;
    text-align: right;
}
</style>

<div class="borrowContainer">
    <h1>📚 استعارة كتاب</h1>
    <img src="<?= $book['image'] ?>" alt="صورة الكتاب">
    <h2><?= htmlspecialchars($book['title']) ?></h2>
    <p>✍️ المؤلف: <?= htmlspecialchars($book['author']) ?></p>
    <p>📂 التصنيف: <?= htmlspecialchars($book['category']) ?></p>
    <p>🔢 النسخ المتاحة: <?= $book['copies'] ?></p>
    <hr>
    <p>💰 السعر: <?= $dailyPrice ?> ريال / يومياً</p>

    <!-- اختيار عدد الأيام -->
    <form method="POST">
        <label for="days">اختر عدد الأيام (حتى <?= $maxDays ?>):</label><br>
        <select name="days" id="days" required>
            <option value="">-- اختر --</option>
            <?php for ($i = 1; $i <= $maxDays; $i++): ?>
                <option value="<?= $i ?>" <?= ($borrowDays == $i ? "selected" : "") ?>><?= $i ?> يوم</option>
            <?php endfor; ?>
        </select>
        <br>
        <button type="submit">احسب</button>
    </form>

    <!-- عرض النتيجة -->
    <?php if ($borrowDays): ?>
        <div class="resultBox">
            <p>📅 تاريخ الاستعارة: <b><?= $borrowDate ?></b></p>
            <p>📅 تاريخ الاسترداد: <b><?= $returnDate ?></b></p>
            <p>💵 المبلغ الكلي: <?= $totalPrice ?> ريال</p>
            <p>🎉 بعد الخصم 10%: <b><?= $discountedPrice ?> ريال</b></p>
            <form action="../Payment/payment.php" method="POST">
                <input type="hidden" placeholder="رقم الكتاب" name="id"  value="<?php echo intval($_GET['id']) ;?>" required >
                <input type="hidden" name="member_id" value="<?= $member_id ?? 'يجب تسجيل الدخول';?>">
                <input type="hidden" name="days" value="<?= $borrowDays ?>">
                <input type="hidden" name="borrow_date" value="<?= $borrowDate ?>">
                <input type="hidden" name="return_date" value="<?= $returnDate ?>">
                <input type="hidden" name="total_price" value="<?= $totalPrice ?>">
                <input type="hidden" name="discounted_price" value="<?= $discountedPrice ?>">
            <button type="submit" name="borrow">استعارة</button>
            </form>   
        </div>
    <?php endif; ?>
</div>

<?php
require_once "../file/footer.php";

// $conn->close();
?>

