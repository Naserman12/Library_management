<div class="content_sec"> 
  <form action="adminpanel.php" method="GET">
    <!-- تحديث نتائج البحث -->
    <input type="hidden" name="page" value="books">
    <input type="search" name="search" placeholder="ادخل كلمة البحث..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    <button type="submit" name="search_btn">بحث</button>
  </form>
  <?php
$book = new Book($conn);
 $category = new Category($conn);
  $result = $book->getBooks();
    if ($result) {
      $seachTerm = $_GET['search'] ?? null;
      if ($seachTerm) {
      ?>
     <?php
     $books = $book->searchBooks($seachTerm);
   if (mysqli_num_rows( $result)  > 0) {
     ?>
      <h1> نتائج البحث</h1>        
      <table border="1">
        <thead>
          <tr>
            <th>صورة</th>
            <th>رقم الكتاب</th>
            <th>العنوان</th>
        <th>المؤلف</th>
        <th>سنة النشر</th>
        <th>النسخ المتاحة</th>                
        <th>تعديل/حذف</th>                
    </tr>
        </thead>
        <tbody>
          <?php foreach ($books as $book): ?>
        <td name="title"><img src="<?php    echo $book['image'];?>" alt="" width="140" height="150"></td>
        <td><?php echo $book['id'];?></td>
        <td name="title"><?php    echo $book['title'];?></td>
        <td name="author"><?php   echo $book['author'];?></td>
        <td name="year"><?php     echo $book['year'];?></td>
        <td name="copies"><?php   echo $book['copies'];?></td>
           <td>
           <a class="edt_btn" href="editBook.php?id=<?= $book['id'];?>"> تعديل</a>|
          <a style="text-decoration: none;" onclick="return confirm('هل انت تريد حذف الكتاب?.')"  href="deleteBook.php?id=<?php echo $book['id']; ?>"  class="del_btn"> حذف
          </a>
          </td> 
        </tr>
        <?php endforeach; ?>
       </tbody>
      </table>
       <?php
   }else{
     echo 'لا توجد نتائج بحث ل'. $seachTerm;
     $books = $book->getBooks();
   }
  } 
   if (mysqli_num_rows( $result)  > 0) {?>
     <h1> جميع الكتب</h1>        
         <table border="1">
         <thead>
           <tr>
             <th>صورة</th>
             <th>رقم الكتاب</th>
             <th>العنوان</th>
         <th>المؤلف</th>
         <th>سنة النشر</th>
         <th>النسخ المتاحة</th>                
         <th>تعديل/حذف</th>                
     </tr>
         </thead>
        <tbody>
        <?php foreach ($result as $book): ?>
          <tr> 
         <td name="title"><img src="<?php    echo $book['image'];?>" alt="" width="150" height="150"></td>
         <td><?php echo $book['id'];?></td>
         <td name="title"><?php    echo $book['title'];?></td>
         <td name="author"><?php   echo $book['author'];?></td>
         <td name="year"><?php     echo $book['year'];?></td>
         <td name="copies"><?php   echo $book['copies'];?></td>
         <td>
            <a class="edt_btn" href="editBook.php?id=<?= $book['id'];?>"> تعديل</a>|
           <a style="text-decoration: none;" onclick="return confirm('هل انت تريد حذف الكتاب?.')"  href="deleteBook.php?id=<?php echo $book['id']; ?>"  class="del_btn"> حذف
           </a>
           </td> 
         </tr>
         <?php endforeach; ?>
        </tbody>
         </table>
         </div>
         <?php
      }
    echo "<a href='addBook.php'>اضافة كتب</a><br>";
    }else{
    echo "لا توجد كتب لعرضها";
    }
//   الغاء الاتصال بقاعدة البيانات  
  // mysqli_close($conn);
?>
