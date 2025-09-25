<?php
session_start();
require_once "../include/db_connect.php"; // الاتصال بقاعدة البيانات
// بيانات PayPal القادمة من JS
$data = json_decode(file_get_contents("php://input"), true);

// ✅ إذا وصل المستخدم للصفحة بعد نجاح الدفع
if (isset($_GET['done'])) {
    ?>
    <!DOCTYPE html>
    <html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <title>نجاح الدفع</title>
        <style>
            body {
                font-family: Tahoma, Arial, sans-serif;
                background: #f4f6f9;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            .card {
                background: #fff;
                padding: 20px 30px;
                border-radius: 10px;
                box-shadow: 0 0 15px rgba(0,0,0,0.1);
                text-align: center;
                max-width: 400px;
            }
            .success {
                color: green;
                font-size: 22px;
                margin-bottom: 10px;
            }
            .fail {
                color: red;
                font-size: 22px;
                margin-bottom: 10px;
            }
            .btn {
                display: inline-block;
                margin-top: 15px;
                padding: 10px 20px;
                background: #0070ba;
                color: #fff;
                text-decoration: none;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div class="card">
            <div class="success">✅ تم الدفع بنجاح</div>
            <p>شكراً لك، لقد تم حفظ بيانات العملية.</p>
            <a href="../BOOKS/home.php" class="btn">العودة للكتب</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}
if (!$data) {
    echo json_encode(["success" => false, "message" => "لا توجد بيانات مستلمة"]);
    exit;
}
$transaction_id  = $data['transaction_id'] ?? null;
$payment_status  = strtolower($data['status'] ?? "failed"); // مثل: COMPLETED, PENDING


if (!isset($_SESSION['payment'])) {
    echo json_encode(["success" => false, "message" => "لا توجد بيانات دفع"]);
    exit;
}
$payment = $_SESSION['payment'];
// بيانات الدفع
$member_id   = $payment['member_id'];
$book_id     = $payment['book_id'];
$days        = $payment['days'];
$total       = $payment['total'];
$discount    = ($total * 0.1); // أو احفظها من قبل
$borrow_date = date("Y-m-d");
$return_date = date("Y-m-d", strtotime("+$days days"));

$sql = "INSERT INTO payment 
        (member_id, book_id, days, total_amount, discount, payment_status, transaction_id, borrow_date, return_date)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiidsssss", $member_id, $book_id, $days, $total, $discount, $payment_status, $transaction_id, $borrow_date, $return_date);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "transaction_id" => $transaction_id,
        "status" => $payment_status
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => $stmt->error
    ]);
}
