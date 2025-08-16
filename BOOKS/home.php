<?php

require_once "../file/head.php";
// include_once '../admin/login.php';
if(isset($_SESSION["memberId"])){
    require_once "../showNews.php";

}
else{
    require_once "../file/head.php";
    echo '<h3>سجل دخول لتتمكن من استعارة الكتب والمزيد!!<br></h3>';
}
// endif;


// <!-- Search php -->
$books = $book->searchBooks($seachTerm);
$book = new Book($conn);
 $category = new Category($conn);
 $result = $book->getBook();
 ?>
 <h2 style="color:black; text-decoration:none; text-align:center;" dir="rtl"><a href="../DigiBooks/showDigiBooks.php">|الكتب الإلكترونية|</a></h2>
 <?php
if($books) {
    if(isset($seachTerm)){
        ?>
    <h2>نتائج البحث</h2>
    <?php ;} ?>
    
    <!-- Products div -->
    <main>
       <?php foreach($books as $book): ?>
                <!-- Products div -->
                <div class="product">
                <!-- product img -->
                <div class="product_img">
                <a href="../Comments/showBookDetiles.php?book_id=<?php echo $book['id'];?>"><img src="<?php echo  $book['image']; ?>" alt="صورة الكتاب"></a>
                    <span class="unvailable"><?php if ($book['copies'] >= 5 ) {
                        echo 'متوفر';
                    }elseif($book['copies'] >0 && $book['copies'] < 5){
                         echo"<span style='background-color: none; width: 6px; height: 5px'> متوفر بكمية <span>";
                         }else{
                            echo "غير متوفر!!.";
                         }
                          ?></span>
                </div>
                <!-- // product img// -->
                <!-- product_section -->
                <div class="product_section">
                    <a href=""><?php echo  $book['author']; ?></a>
                </div>
                <!--// product_section// -->
                <!-- Product name -->
                <div class="product_name">
                    <a href=""><?php echo  $book['title']; ?></a>
                </div>
                <!--// Product name // -->
                <!-- Product price -->
                <div class="product_price">
                    <a href=""><?php echo  $book['year']; ?> :سنة النشر</a>
                </div>
                <!--// Product price // -->
                <!-- Product descrption -->
                <div class="product_description">
                    <a href=""><i class="fa-solid fa-eye"></i><?php echo  $book['copies']; ?> :عدد النسخ</a>
                </div>
                <!--// Product description // -->
                <!-- Add To cart -->
                <div class="submit">
                    <?php if(isset($_SESSION['memberId'])): if($book['copies'] > 0){?>
                        <a class="add_to_cart" name="borrow" href="../borrow/Borrow.php?id=<?php echo $book['id'];?>">استعارة الكتاب</a>
                 </div>
                    <div class="submit">
                        <?php  }else{?>
                        <a class="add_to_cart"  onclick="return confirm('الكتاب غير متوفر')" name="borrow" href="#">استعارة الكتاب</a>
                        <?php }else :  ?>
                        <a class="add_to_cart"  onclick="return confirm('يجب تسجيل الدخول أولا.')" name="borrow" href="../admin/login.php">استعارة الكتاب</a>
                      <?php
                      endif;
                     ?>
                     </div>
                <!--// Add To cart //-->
            </div>
            <!--// Products div //-->
            <?php endforeach; ?>
        </main>
        <!--// Products div //-->
<?php
}else{
    echo ' لا توجد نتيجة للبحث.<br>';
    echo '<h2> جميع الكتب<h2><br>';

    // $book = new Book($conn);
    //  $category = new Category($conn);
    //   $result = $book->getBook();
    
      if (mysqli_num_rows( $result)  > 0) {
            $books = $book->getBook();
            // echo "<pre>";
            // var_dump($book);
            // echo "</pre>";
            ?>
            <!-- <div><?//php echo $book['id'];?></div> -->
            <!-- Products div -->
             
            <main>
                <?php 
                foreach ($books as $book): ?>
                    <!-- Products div -->
                    <div class="product">
                    <!-- product img -->
                    <div class="product_img">
                    <img src="<?php echo  $book['image']; ?>" alt=""><a href=""></a>
                    <span class="unvailable"><?php if ($book['copies'] >= 5 ) {
                        echo 'متوفر';
                    }elseif($book['copies'] >0 && $book['copies'] < 5){
                       echo"<span style='background-color: none; width: 6px; height: 5px'> متوفر بكمية <span>";
                         }else{
                            echo "غير متوفر!!.";
                         }
                          ?></span>
                   </div>
                    <!-- // product img// -->
                    <!-- product_section -->
                    <div class="product_section">
                        <a href=""><?php echo  $book['author']; ?></a>
                    </div>
                    <!--// product_section// -->
                    <!-- Product name -->
                    <div class="product_name">
                        <a href=""><?php echo  $book['title']; ?></a>
                    </div>
                    <!--// Product name // -->
                    <!-- Product price -->
                    <div class="product_price">
                        <a href=""><?php echo  $book['year']; ?> :سنة النشر</a>
                    </div>
                    <!--// Product price // -->
                    <!-- Product descrption -->
                    <div class="product_description">
                        <a href=""><i class="fa-solid fa-eye"></i><?php echo  $book['copies']; ?> :عدد النسخ</a>
                    </div>
                    <!--// Product description // -->
                    <!-- Add To cart -->
                    <div class="submit">
                         <?php if(isset($_SESSION['memberId'])){ if($book['copies'] > 0){?>
                         <a class="add_to_cart" name="borrow" href="../borrow/Borrow.php?id=<?php echo $book['id']; ?>">استعارة الكتاب</a>
                        <?php }else{ echo "الكتب غير متوفر حاليا!!";}  }else { ?>
                            <a class="add_to_cart"  onclick="return confirm('يجب تسجيل الدخول أولا.')" name="borrow" href="../admin/login.php">استعارة الكتاب</a>
                          <?php ; } ?>
                   </div>
                    <!--// Add To cart //-->
                <!-- // Products div // -->
            </div>
            <?php endforeach; ?>
        </main>
            <!--// Products div //-->
            <?php
         
        }
        // else{
        //     echo "لا توجد كتب لعرضها";
        // }
}

?>

</form>  
</div>
</div><br><br>
<a dir="rtl" style="text-decoration: none; color:black; font-size:28px; text-align:center; " class="Edtbtn" href="../process_request.php">ملاحظات ||</a>
<a dir="rtl" style="text-decoration: none; color:black; font-size:28px; text-align:center; " class="Edtbtn" href="../USERS/Discussion/showDiscussions.php">المناقشات..</a>
<?php
//   الغاء الاتصال بقاعدة البيانات 
 

include ("../file/footer.php");
// mysqli_close($conn);
?>

