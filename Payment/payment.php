<?php
session_start();
require_once "../USERS/MemberClass.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrow'])) {
    $member_id = $_POST['member_id'];
    $book_id   = $_POST['id'];
    $book = new Book($conn);
    $book1 = $book->getBook($book_id);
    $price_per_day = $book1['price'];
    $days = $_POST['days']; // الأيام المختارة
    $total = $price_per_day * $days;

    // تطبيق خصم 10%
    $discount = $total * 0.1;
    $total_after_discount = $total - $discount;

    // حفظ البيانات مؤقتاً في السيشن
    $_SESSION['payment'] = [
        'member_id' => $member_id,
        'book_id'   => $book_id,
        'days'      => $days,
        'total'     => $total_after_discount,
    ];
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>الدفع</title>
</head>
<body style="margin: 0;">
    <section style="margin: 50px auto;">
        <h1>الدفع باستخدام PayPal</h1>
        <p>المبلغ المطلوب: <?php echo $_SESSION['payment']['total'] ?? 10; ?> ريال</p>
        <!-- زر بايبال -->
        <div id="paypal-button-container"></div>
    </section>
    <script src="https://www.paypal.com/sdk/js?client-id=AcoHPinBUTy2H-Ho9LAeap21_gKqHSN0PyVB-li74dJoZgXS9rGzCi1qp07-vOV_1qUMCqh6YUZmmHfi&currency=USD"></script>
    <script>
    paypal.Buttons({
      createOrder: function(data, actions) {
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: '<?php echo $_SESSION['payment']['total']; ?>',
              currrncy_code: 'SAR',
            }
          }]
        });
      },
      onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
           // إرسال بيانات العملية إلى success.php
        fetch("success.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            transaction_id: details.id,
            status: details.status
        })
        })
         .then(response => response.json())
            .then(result => {
                if (result.success) {
                alert("✅ تم الدفع بنجاح، رقم العملية: " + result.transaction_id);
                window.location.href = "success.php?done=1"; // إعادة توجيه لصفحة نجاح مرتبة
                } else {
                alert("❌ فشل في حفظ الدفع");
                }
        });
        });
      }
    }).render('#paypal-button-container');
  </script>
</body>
</html>
