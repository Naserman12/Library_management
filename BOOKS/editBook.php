
<?php
// include '../include/db_connect.php';
// include 'Book.php';
include 'category.php';
$category = new Category($conn);
// التحقق من معرف الكتاب 
    $_GET['id'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$book = new Book($conn);
// echo '<pre>';
// var_dump($_GET['id']);
// echo '</pre>';
if ($id === 0) {
    die('المعرف غير صالح');
}

if ($id) {
    // if(isset($_POST['upload'])):
        $bookData = $book->getBookId($id);
        $book->id = $bookData['id'];
        $book->title = $bookData['title'];
        $book->author = $bookData['author'];
        $book->category = $bookData['category'];
        $book->detil = $bookData['detil'];
        $book->year = $bookData['year'];
        $book->copies = $bookData['copies'];
        $book->img = $bookData['image'];
    // endif;
      
    // echo '<pre>';
    // var_dump($book);
    // echo '</pre>';
// echo 'ID = '. $id;
$categories = $category->getCaty();
    ?> 
    <style>
        /* تنسيق أساسي */
body {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background-color: #f5f5f5;
    font-family: Arial, sans-serif;
    color: black;
}

/* تنسيق الحاوية */
.select-container {
    width: 200px;
    text-align: center;
}

.select-container label {
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

    </style>
   <form  action="update.php?id=<?php echo  $id;?>"  method="POST" enctype="multipart/form-data">
            <label for=""></label>
            <input type="hidden" name="id" class="box" value="<?php echo htmlspecialchars($book->id); ?>">
            <label for="">العنوان:</label>
            <input type="text" name="title" class="box" value="<?php echo htmlspecialchars($book->title); ?>">
            <label for="">المؤلف :</label>
            <input type="text" name="author" class="box" value="<?php echo htmlspecialchars($book->author); ?>">
            <label for="">تفاصيل الكتاب :</label>
            <input type="text" name="detil" class="box" value="<?php echo htmlspecialchars($book->detil); ?>">
            <label for="">السنة :</label>
            <input type="text" name="year" class="box" value="<?php echo htmlspecialchars($book->year); ?>">
            <label for="">عدد النسخ :</label>
            <input type="number" name="copies" class="box" value="<?php echo htmlspecialchars($book->copies); ?>">
            <!--======================Category==================-->
            <div class="select-container">

                    <label for="">التصنيفات</label>
        <select name="category" id="">
            <option value="">اختر التصنيف</option>
            <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['name']; ?>">
                <?php echo $category['name']; ?>
            </option>
            <?php endforeach; ?>
        </select>
            </div>
            <!--==================Category==================-->
            <!--/====================Images=================-->
            <br>
            <input type="file" id="file" class="btn" style="display:none;" name="image" required>
            <label for="file">اختر صورة</label>
            <button class="edt-btn" name="upload" >رفع الصورةّ</button>
            <br><hr>
            <!--//====================Images=================//-->
            <!-- <button type="submit" name="edt_btn">تحديث</button> -->
                </form>
                <?php
    }else {echo 'لم يتم استلام البيانات بشكل صحيح';}
            // } else {
            //     echo 'لم يتم العثور على معلومات الكتاب';
            // };
       ?>




