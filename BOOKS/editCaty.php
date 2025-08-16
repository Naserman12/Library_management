<style>
    body{
        background-color: black;
    }
</style>
<?php
// include '../include/db_connect.php';
include 'category.php';
// التحقق من معرف الكتاب 
    $_GET['id'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$category = new category($conn);
if (!$id) {
    die('المعرف غير صالح');
}

if ($id) {
        $catyData = $category->getCategoryById($id);
        if ($catyData) {
    ?> 
  <form  action="updateCaty.php?id=<?php echo  $id;?>"  method="POST">
            <label for=""></label>
            <input type="hidden" name="id" class="box" value="<?php echo $id; ?>">
            <label for="">اسم التصنيف</label>
            <input type="text" name="name" class="box" value="<?php echo htmlspecialchars($catyData['name']); ?>">
            <button type="submit" name="submit">تحديث</button>
                </form>
                <?php
}
}else {echo 'لم يتم ارستلام البيانات بشكل صحيح';}
       ?>




