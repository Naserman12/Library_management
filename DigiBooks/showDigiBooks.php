<?php
require '../file/head.php';
include_once '../BOOKS/category.php';

if(isset($_SESSION["memberId"])){
    // require_once "../BOOKS/showNews.php";

} else {
    echo '<h3>سجل دخول للتمكن من استعارة الكتب والمزيد!!<br></h3>';
}
$file = isset($_GET['file']) ? $_GET['file'] : null;
 $Digibook = new DigitalBook($conn);
$result = $Digibook->getDigiBooks();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>الكتب الإلكترونية</title>
  <style>
    body {
      margin-top: 0;
      background-color: #f5f5f5;
      font-family: Arial, sans-serif;
      text-align: center;
    }
    .ebook-container {
      display: grid;
      gap: 20px;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      width: 100%;
      max-width: 1000px;
      margin: auto;
    }
    .ebook {
      background-color: #fff;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      text-align: center;
    }
    .download-btn {
      display: inline-block;
      margin: 5px;
      padding: 10px 15px;
      background-color: #4CAF50;
      color: #fff;
      border-radius: 5px;
      text-decoration: none;
    }
    .Edtbtn {
      display: inline-block;
      margin: 5px;
      padding: 10px 15px;
      background-color: yellow;
      color: #fff;
      border-radius: 5px;
      text-decoration: none;
    }
    iframe {
      width: 100%;
      height: 90vh;
      border: none;
      margin-top: 20px;
    }
  </style>
</head>
<body>
<?php if ($file):
$Digibook->views($file);
?>
    <!-- ✅ حالة قراءة كتاب -->
    <h1>قراءة الكتاب</h1>
    <iframe src="../books_files/<?php echo htmlspecialchars($file); ?>"></iframe>
    <br><br>
    <a href="showDigiBooks.php" class="download-btn">🔙 الرجوع لقائمة الكتب</a>
<?php else: ?>
    <!-- ✅ حالة عرض قائمة الكتب -->
    <h1>الكتب الإلكترونية</h1>
    <h2><a href="../BOOKS/home.php">|الكتب الورقية|</a></h2>
    <a dir="rtl" style="text-decoration: none; color:black; font-size:28px; text-align:center; " class="Edtbtn" href="../USERS/Discussion/showDiscussions.php">المناقشات..</a>

    <main class="ebook-container" dir="rtl">
    <?php
      foreach($result as $book):  ?>
        <div class="ebook">
          <img src="<?php echo $book['image']; ?>" alt="صورة الكتاب" width="100%">
          <h2><?php echo $book['title']; ?></h2>
          <p>المؤلف: <?php echo $book['author']; ?></p>
          <p>سنة النشر: <?php echo $book['year']; ?></p>
          <p>النوع: <?php echo $book['bookType']; ?></p>
          <a href="../<?php echo $book['file_name']; ?>" download class="download-btn">تحميل</a>
          <a href="showDigiBooks.php?/file=<?php echo urlencode($book['file_name']); ?>" class="download-btn">قراءة</a>
        </div>
      <?php endforeach; ?>
    </main>
<?php endif; ?>
<?php include ("../file/footer.php"); ?>
<?php mysqli_close($conn); ?>
</body>
</html>