<style>
  body{
    background-color:black;
    color: antiquewhite;
    align-items: center;
    text-align: center;
  }
</style>
<?php
$category = new Category($conn);
$book = new Book($conn);
$DigiBook = new DigitalBook($conn);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['submit'])) {
    if (!empty( $_POST['title']) || !empty($_POST['author']) || !empty($_POST['year']) || !empty($_POST['copies']) || !empty($_POST['detil']) || !empty( $_FILES['image'])) {
      echo "تاكد من ملء الحقول";
      return 0;
    }
      $book->title = $_POST['title'];
      $book->author = $_POST['author'];
      $book->year = $_POST['year'];
      $book->copies= $_POST['copies'];
      $book->img = $_FILES['image'];
      $book->detil = $_POST['detil'];
      $category->name = $_POST['category_id'];
      $bookType = $_POST['bookType'];
      //  print_r( $category->name ) ;
      // الحصول على مسار الملف المؤقت 
      $img_location = $_FILES['image']['tmp_name'];
      // تعين مسار الوجهة النهائي
      $img_name = $_FILES['image']['name'];
      // ملف رفع الصور
     $img_up = "../images/".$img_name;
     if ($DigiBook->isBookExists($book->title)) {
      echo "يوجد كتاب بنفس العنوان !!.";
      return 0;
     }else{
     if($bookType === 'paper'){
     $insert = $book->addBook($book->title,$book->author,$book->year, $category->name,$book->detil,$book->copies, $bookType, $img_up);
      if ($insert) {
        // نقل الملف من المسار المؤقت الى الوجهة
        if(move_uploaded_file($img_location, $img_up)){
          //  الانتقال الى صفحة اخرى JS
          echo "<script> alert('تم إضافة الكتاب');
          window.location.href='addBook.php';
          </script>";
        }else{
          echo "لم يتم رفع الصورة بنجاح";
         }
        }
      }else{
        $downlaodLink = $_POST['downlaodLink'];
        $readLink = $_POST['readLink'];
        $insert = $DigiBook->addDigiBook($book->title,$book->author,$book->year, $category->name,$book->detil,$book->copies, $bookType, $img_up, $downlaodLink, $readLink);
        if ($insert) {
          // نقل الملف من المسار المؤقت الى الوجهة
          if(move_uploaded_file($img_location, $img_up)){
            //  الانتقال الى صفحة اخرى JS
            echo "<script> alert('تم إضافة الكتاب');
            window.location.href='addBook.php';
            </script>";
          }else{
            echo "لم يتم رفع الصورة بنجاح";
           }
          }
      }
    }
  }
} 
$categories = $category->getCaty();
  ?>
<style>
        /* تنسيق أساسي */
body {
    /* display: flex; */
    align-items: left;
    justify-content: left;
    height:100vh;
    background-color: #f5f5f5;
    font-family: Arial, sans-serif;
    color: black;
}

/* تنسيق الحاوية */
select {
    width: 200px;
    text-align: center;
}
select label {
    display: block;
    margin-bottom: 8px;
    font-size: 1em;
    color: #333;
}
/* تنسيق قائمة الخيارات */
select {
    width: 100%;
    padding: 10px;
    font-size: 1em;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #fff;
    color: #333;
    cursor: pointer;
    appearance: none; /* إزالة السهم الافتراضي */
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%234CAF50' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E"); /* سهم مخصص */
    background-repeat: no-repeat;
    background-position: right 10px center;
}

/* تنسيق إضافي عند تمرير الفأرة */
select:hover {
    border-color: #4CAF50;
}

/* تنسيق عند التركيز */
select:focus {
    outline: none;
    border-color: #4CAF50;
    box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
}
form{
  margin: 5px auto;
  width: 650px;
}
    </style>
    <form method="post" action="addBook.php" enctype="multipart/form-data">
      <!-- التصنيف: <input type="text" name="category" required><br> -->
       <h2>صفحة اضافة الكتب</h2>
      <img src="../images/drink.png" alt="logo" width="250px"><br>
    <label for=""> العنوان: </label><br>
    <input type="text" name="title"  required><br>
         <label for="">المؤلف:</label><br>
          <input type="text" name="author" required ><br>
        <label for="">تفاصيل الكتاب :</label><br>
        <input type="text" name="detil" ><br>
        <label for="">السنة: </label><br>
        <input type="text" name="year" required ><br>
     <label for="">  عدد النسخ:</label><br>
     <input type="number" name="copies" ><br>
    
     <label for="">التصنيفات</label>
     <select name="category_id" id="">
      <option value="">اختر التصنيف</option>
      <?php foreach ($categories as $category): ?>
        <option value="<?php echo $category['name']; ?>">
          <?php echo $category['name']; ?>
        </option>
      <?php endforeach; ?>
     </select>
     <!-- <input type="text" name="category_name" required><br> -->
             <!-- اختيار نوع الكتاب -->
             <label for="">نوع الكتاب:</label>
        <input type="radio" id="paperRadio" name="bookType" value="ورقي" checked>
        <label for="paper">الكتب الورقية:</label>
        <input type="radio" id="DigiRadio"  name="bookType" value="الكتروني">
        <label for="Digi">الكتب الإلكترونية:</label>
        <!-- الروابط للكتب -->
         <div id="DigiOption" style="display: none;">
             <label for="">رابط التحميل</label>
             <input type="text" name="downlaodLink">

             <label for="">رابط  القراة</label>
             <input type="text" name="readLink">
            </div>
            <!-- اختيار نوع الكتاب -->
     <!--/====================Images=================-->
     <br>
     <input type="file" id="file" class="btn" style="display:none;" name="image" >
     <label for="file">اختر صورة</label>
     <!-- <button class="edt-btn" name="submit" >رفع الصورةّ</button> -->
     <br><hr>
     <!--//====================Images=================//-->
     <!-- <a href="/listBooks.php/#heading">عرض جميل النتجات</a><br><br> -->
    
      <input type="submit" name="submit" value="اضافة الكتاب">
      <a href="listBooks.php">عرض الكتب</a>
    </form>


  <script>
    // التحكم في نوع الكتب
        document.addEventListener('DOMContentLoaded', function(){
            let DigiRadio =document.getElementById("DigiRadio");
            let paperRadio =document.getElementById("paperRadio");
            let DigiOption =document.getElementById("DigiOption");
            DigiRadio.addEventListener("change", function(){
              // اذا اختار الكتب الالكترونية
                if (DigiRadio.checked) {
                    DigiOption.style.display = "block";
                }
            });
            // اذا اختار الكتب الورقية
            paperRadio.addEventListener("change", function(){
                if (paperRadio.checked) {
                    DigiOption.style.display = "none";
                }
            });
        })
    </script>