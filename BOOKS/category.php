
<?php
 include 'Book.php';

 //  <------------كلاس التصنيفات---------->
 class category{
    private $conn;
    public $id;
    public $name;
    public $table = 'categories';
// <--------قاعدة البيانات -------->
public function __construct($db){
    $this->conn = $db;
}
// <//--------قاعدة البيانات --------//>
// // <---------اضافة تصنيف جديد--------->
// <--========تم دمجها مع صفحة حفظ التصنيف========-->
// public function addCategory($name){
//     $query = "INSERT INTO" .$this->table. "( name) VALUES (?)";
//     echo $query. 'اسم التصنيف<br>';
//     echo $name. 'اسم التصنيف<br>';
//     $stmt = $this->conn->prepare($query);
//     $stmt->bind_param("s", $name);
//      $stmt->execute();
//     return true;
// }
// <//---------اضافة تصنيف جديد---------//>
// <-----------جلب التصنيفات----------->
public function getCaty(){
    $query = "SELECT * FROM ".$this->table;
    $result = mysqli_query($this->conn, $query);
    $categories = [];
    if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
      $categories[] = $row; #تخزين التصنيفات في مصفوفة
      // echo "<pre>";
      // print_r($categories);
      // echo "</pre>";
    }
    // return $result;
  }else{
    echo"لا توجد تصنيفات.";
  }
  return $categories;
}
// <//---------جلب التصنيفات---------//>
// <---------جلبب التصنيف باستخدام المعرف-------->
public function getCategoryById($id){
    $query = "SELECT name FROM ".$this->table." WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();


}
// <//---------جلب التصنيف باستخدام المعرف--------//>
// <---------تعديل التصنيفات-------->
public function updateCategory($name, $id){
    $query = "UPDATE ". $this->table." SET name = ? WHERE id = ?";
    // echo $query;
    $stmt = $this->conn->prepare($query);
    var_dump($name);
    var_dump($id);
    $stmt->bind_Param("si", $name, $id);
    //  return
      $stmt->execute();
}
// <//---------تعديل التصنيفات--------//>
// <----------حفظ التصنيف--------->
public function saveCaty($name){
    $query = "SELECT * FROM  categories WHERE name = '$name'";
    // echo $query;
    // echo '<br>name: '.$name. '<br>' ;
    $stmt = mysqli_query($this->conn,$query);
    // $stmt->bind_param("s", $name);
    if($stmt->num_rows > 0){
    echo'يوجد تصنيف بنفس الاسم.';
    header( "REFRESH:2; URL = ../admin/adminpanel.php");
    return false;
    }
    
    $query = 'INSERT INTO  categories (name) VALUES (?)';
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('s', $name);
    // echo '<br>name: '.$name. '<br>' ;
    if ($stmt->execute()) {
      echo 'تم اضافة التصنيف بنجاح';
      header( "REFRESH:2; URL = ../admin/adminpanel.php");
      return true;
    }else{
        echo 'حدث خطأ لم يتم الإضافة';
        header( "REFRESH:3; URL = ../admin/adminpanel.php");
        return false;
    }
}
// <//----------حفظ التصنيف---------//>
  //   <--------حذف--------->
  public function deleteCaty($id){
    $query = "DELETE FROM categories WHERE id=?";
    $tsmt = $this->conn->prepare($query);
    // echo $id;
    $tsmt->bind_param("i", $id);
    if (!$tsmt->execute()) {
      die("يوجد خطا".mysqli_error($this->conn));
    }
    if($tsmt->execute()){
        // echo 'تم الحذف بنجاح';
        echo 'تم حذف الكتاب';
        header( "REFRESH:2; URL = ../admin/adminpanel.php");
    }else{
      echo 'لم يتم حذف التصنيف.';
      header( "REFRESH:2; URL = ../admin/adminpanel.php");
    }
    //  mysqli_query($this->conn, "DELETE FROM".$this->table ."  WHERE  id=$id");
     
  }
//   <--//------حذف-------//-->
// <---------=--------//>
}

//  <//------------كلاس التصنيفات----------//>
// <--======= Testing========-->
// $category = new Category($conn);
// $category->name = 'New';
// $category->saveCaty($category->name);
// $category->addCategory($category->name);


// <//--======= Testing========--//>
?>