<?php
require '../file/head.php';
include_once '../BOOKS/category.php';
if(isset($_SESSION["memberId"])){
    // require_once "../BOOKS/showNews.php";
}
else{
    
    echo '<h3>سجل دخول للتمكن من استعارة الكتب والمزيد!!<br></h3>';
}
   
?>

<style>
    /* تنسيق أساسي */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    margin-top: 95px;
    background-color: #f5f5f5;
    /* background-color: #333; */
    display: flex;
    align-items: center;
    flex-direction: column;
    padding: 20px;
}

h1 {
    font-size: 2em;
    margin-bottom: 20px;
    color: #4CAF50;
} 
h4 {
    font-size: 1em;
    margin-bottom: 10px;
    color: #4CAF50;
} 
.ebook-container {
    display: grid;
    gap: 20px;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    width: 100%;
    max-width: 800px;
}

/* تنسيق كل كتاب */
.ebook {
    background-color: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.ebook h2 {
    color: #333;
    font-size: 1.5em;
    margin-bottom: 10px;
}

.ebook p {
    color: #666;
    margin-bottom: 10px;
    font-size: 0.9em;
}

/* تنسيق زر التحميل */
.download-btn {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 15px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    font-size: 1em;
    cursor: pointer;
}
a{
    text-decoration:solid;
}

.download-btn:hover {
    background-color: #45a049;
}
header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000; /* اجعل الهيدر يظهر فوق المحتوى */
}
main .ebook .product_img .unvailable{
    /* اضافة العنصر */
 position: absolute;
 top: 18;
 left: 0.5;
 
 /* إمالة الصورة */
 transform:rotate(-45deg);
 /* transform: rotate(-50deg); */
 width: 50px;
 text-align: center;
 font-size: 12px;
 font-weight: bold;
 color: black;
 padding: 5px 5px;
 background-color: greenyellow;
 border: 0.5px solid ;
 z-index: 1000; 
}
/*---------//products//------*/

</style>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الكتب الإلكترونية</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
   
        <h1>الكتب الإلكترونية</h1>
        <?php
// <!-- Search php -->
$Digibook = new DigitalBook($conn);
$category = new Category($conn);
$books = $Digibook->searchDigiBooks($seachTerm);
$result = $Digibook->getDigiBooks();

?>
<h2><a href="../BOOKS/home.php">|الكتب الورقية|</a></h2>
    <?php if(isset($seachTerm)):   ?>
        <h4 dir="rtl">سيتم تفعيل خاصية البحث لاحقا!!</h4>
        <?php endif;  ?>

<main class="ebook-container" dir="rtl">
    <?php foreach($result as $book): ?>
        <div class="ebook">
                 <!-- product img -->
                 <div class="product_img">
                 <a href="../Comments/showBookDetiles.php?book_id=<?php echo $book['id'];?>"><img src="<?php echo  $book['image']; ?>" alt="صورة الكتاب"></a>
                 <!-- يوجد خطأ في اظهار حالة المنتج  -->
                 <!-- <span class="unvailable"><?php // if ($book['copies'] >= 5 ) {
                        // echo 'متوفر';
                    // }elseif($book['copies'] >0 && $book['copies'] < 5){
                        //  echo"<span style='background-color: none; width: 8px; height: 5px'> متوفر بكمية <span>";}
                        //  else{ echo "غير متوفر!!.";} ?></span> -->
                   </div>
                    <!-- // product img// -->
                    <h2><a href=""><?php echo  $book['title']; ?></a></h2>
                    <p>المؤلف: <?php echo  $book['author']; ?></p>
                    <p>سنة النشر:  <?php echo  $book['year']; ?></p>
                    <p>سنة النشر:  <?php echo  $book['bookType']; ?></p>
                    <a href="<?php echo  $book['downloadLink']; ?>" download class="download-btn">تحميل الكتاب</a><br>
                    <a href="<?php echo  $book['readLink']; ?>" download class="download-btn">قرأة الكتاب</a>
                </div>
                <?php endforeach; ?>
        <!-- يمكنك تكرار نفس الكود لكل كتاب -->     
    </main>
    <?php 
    
    ?>
    </div><br><br>
    <h2><a style="text-decoration: none; color:black; text-align:center;" class="edt_btn" href="../process_request.php">ملاحظات</a></h2>
    <?php
    include ("../file/footer.php");
    //   الغاء الاتصال بقاعدة البيانات 
    mysqli_close($conn);
    ?>
</body>
</html>
