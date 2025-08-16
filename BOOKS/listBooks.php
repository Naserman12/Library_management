
<?php
// include '../include/db_connect.php';
include 'category.php';

$book = new Book($conn);
 $category = new Category($conn);
  $result = $book->getBook();

// echo  $book->getBook() .'<br> done';
    if ($result) {
      $seachTerm = $_GET['search'] ?? '';
        ?>
        <form action="" method="GET">
          <input type="search" name="search" placeholder="ادخل كلمة البحث..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
          <button type="submit" name="search_btn">بحث</button>
        </form>
        <?php
        $books = $book->searchBooks($seachTerm);
      if ($seachTerm) {
?>
        <?php foreach($books as $book): ?>
          <div class="book">
            <h2>نتائج البحث</h2>
            <h3><?= htmlspecialchars($book['title']) ?></h3>
            <p><?= htmlspecialchars($book['author']) ?></p>
            <p><?= htmlspecialchars($book['category']) ?></p>
          </div>
          <?php endforeach; ?>
          <?php
      }else{
        // echo 'لا توجد نتائج بحث ل'. $seachTerm;
        $books = $book->getBook();
      }
        // $book->title = 'title';
        // $book->author = 'author';
        // $book->category = 'caregory';
        // $book->year = 'year';
        // $book->copies = 'copies';
    
    if (mysqli_num_rows( $result)  > 0) {
      ?>
      <style>
        body{
          background-color: #565656;
        }
                 .del_btn, .edt_btn{
          color: white;
          font-size: 20px;
          padding: 8px 18px;
          border-radius: 2px;
          border-radius: 10px;
          border: 1px solid rgb(56, 55, 55);
          margin-right: 5px;
          text-decoration: none;
        }
        .del_btn{
          background-color: rgb(218, 19, 19);
        }
         .del_btn:hover{
            background-color: #580f0f;
        }
        .edt_btn{
    color: black;
    background-color: rgb(216, 144, 11);
}
.edt_btn:hover{
    background-color: rgb(126, 83, 5);
    color: white;
}
      </style>
      <!-- <form action="editBook.php" method="GET"> -->
        <h1>قائمة الكتب</h1>
        
        <table border="1">
        <thead>
          <tr>
            <th>صورة</th>
            <th>رقم الكتاب</th>
            <th>العنوان</th>
        <th>المؤلف</th>
        <th>التصنيف</th>
        <th>سنة النشر</th>
        <th>النسخ المتاحة</th>                
        <th>تعديل/حذف</th>                
    </tr>
        </thead>

       <tbody>
       <?php foreach ($books as $book): ?>
        <td name="title"><img src="<?php    echo $book['image'];?>" alt="" width="150" height="150"></td>
        <td><?php echo $book['id'];?></td>
        <td name="title"><?php    echo $book['title'];?></td>
        <td name="author"><?php   echo $book['author'];?></td>
        <td name="category"><?php echo $book['category'];?></td>
        <td name="year"><?php     echo $book['year'];?></td>
        <td name="copies"><?php   echo $book['copies'];?></td>
           <td>
           <a class="edt_btn" href="editBook.php?id=<?= $book['id'];?>"> تعديل</a>  ||
          <a style="text-decoration: none;" onclick="return confirm('هل انت تريد حذف الكتاب?.')"  href="deleteBook.php?id=<?php echo $book['id']; ?>"  class="del_btn"> حذف
          </a>
          <!-- <a href='deleteBook.php?id=".$row['id']."' >حذف</a> -->
          </td> 
        </tr>
        <?php endforeach; ?>
       </tbody>
        </table>
        <!-- </form> -->
        
        <?php
     }
     echo "<a href='addBook.php'>اضافة كتب</a><br>";
    }else{
    echo "لا توجد كتب لعرضها";
    }
//   الغاء الاتصال بقاعدة البيانات  
  // mysqli_close($conn);
?>
