<?php

// use function PHPSTORM_META\type;
// include '../USERS/MemberClass.php';
    require_once $_SERVER['DOCUMENT_ROOT']. '/library/include/db_connect.php';
    // include 'category.php';
    // <----------كلاس الكتب--------->
    
    class Book{
        private $conn;
        // الخصائص
        public $id;
        public $title;
        public $author;
        public $category;
        public $detil;
        public $year;
        public $copies;
        public $img;
        public function __call($methode, $params){
                echo "The method [ " .$methode."] Not Found  Or Bot Accessible<br>";
                print_r($params);
        }

        public function __construct($db){
            $this->conn = $db;
    }
    //   <-------- اضافة البحث-------->
        public function searchBooks($books){
            $sql = "SELECT * FROM books WHERE bookType = 'paper' AND title LIKE? OR author LIKE?";
            $stmt = $this->conn->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error preparing query: '. $this->conn->error);
            }
            $books = '%' . $books. '%';
            $stmt->bind_param('ss',  $books, $books);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    //   <//-------- اضافة البحث--------//>
    
    
    //   <-------- اضافة كتب-------->
    // public function addBook(){
    //     $query = "INSERT INTO books (title, author, category, year, copies, ) VALUES ('$this->title', '$this->author', '$this->category', '$this->year', '$this->copies')";
    //     $stmt = $this->conn->prepare($query);
    //     // $stmt->bind_Param("sssii", $this->title, $this->author, $this-> $this->category, $this->year, $this->copies);
    //     if ($stmt->execute()) {
    //        return true;
    //     }
    //     return false;
    // }      
    // <-------- اضافة كتب-------->
public function addBook($title, $author, $year, $categoryName, $detil, $copies, $img, $bookType){
    // var_dump($category_id);
    $sql = "INSERT INTO books (title, author, year, category, detil,  copies, image, bookType) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
     $stmt = $this->conn->prepare($sql);
    $stmt->bind_param('sssssiss', $title, $author, $year, $categoryName, $detil, $copies, $img, $bookType);
    
    $stmt->execute();
    
    return true;
}
// <//-------- اضافة كتب--------//>
    //   <--//-------- اضافة كتب--------//-->
    //   <-------- تعديل الكتب--------->
      public function updateBook( $title, $author, $category, $year, $detil, $copies,  $img, $id){
         $query ="UPDATE books SET title=?, author=?, category=?, year=?, detil=?, copies=?, image=? where id=?";  ##"UPDATE  books SET title='$title', author=' $author', category='$category', year='$year', copies=$copies, image='$img'";## 
        echo $query;
        $stmt = $this->conn->prepare($query);
        if ($stmt->affected_rows === null) {
            // echo '$stmt Doing..';
            throw new Exception('Error preparing query: '. $this->conn->error);
        }
        // var_dump($stmt ) ;
        $stmt->bind_param("sssssisi", $title, $author, $category, $year,$detil, $copies, $img, $id) ;
        $stmt->execute();
        if (!$stmt->execute()) {
            throw new Exception("'errror'". $this->conn->error);
        }
       
        // $title = $this->title;
        // $author = $this->author;
        // $category = $this->category;
        // $year = $this->year;
        // $copies = $this->copies;
        // $img = $this->img;
        // $id = $this->id;

        $stmt->execute();
        return true;
        // if ($stmt->affected_rows === null) {
        //     // echo '$stmt Doing..';
        //     throw new Exception('Error preparing query: '. $stmt->error);
        // }
        }
      //   <--//------ تعديل الكتب-------//-->
      //   <--------حذف--------->
      public function deleteBook($id){
        $query = "DELETE FROM books WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // die ("Error in prepare statement: ".$this->conn->error);
           return 1;
        }else{
            return false;
        }
        // return $stmt->execute();
      }
    //   <--//------حذف-------//-->
    //   <--------عرض الكتب --------->
        public function getBook(){
            $query = "SELECT * FROM books";
            $result = mysqli_query($this->conn, $query);
            return $result;
        }
    //   <--//------عرض الكتب -------//-->

    // <------جلب معرف الكتب------->
public function getBookId($id) {
  // تحضير الاستعلام لجلب الكتاب بناءً على المعرف
  $query = "SELECT * FROM books WHERE id = ?";
  $stmt = $this->conn->prepare($query);
// ربط المتغيرات
$stmt->bind_param("i", $id);
// تنفيذ الاستعلام
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    echo '$stmt Doing..';
    // throw new Exception('Error preparing query: '. $stmt->error);
}
return $result->fetch_assoc();
// التحقق من وجود البيانات
}
// <//------جلب معرف الكتب-------//>
// <---------جلب جميع الكتب-------->
      public function getAllBooks(){
        $query = " SELECT books.id, books.title, books.author, books.year,
         books.copies, caategoty.name AS category FROM 
        ". $this->conn. "LEFT JOIN categories ON books.category_id = category.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "لم يتم جلب جميع الكتب";
      }
      return $result->fetch_all(MYSQLI_ASSOC);
      // <//---------جلب جميع الكتب--------//>
    }
    // <//----------كلاس الكتب---------//>
}
Class DigitalBook extends Book{
    private $conn;
    public $downloadLink;
    public $readLink;
    public function __construct($db){
        $this->conn = $db;
        // parent::__construct($id, $title, $author, $year, $category, $detil, $copies, $img);
        // $id, $title, $author, $year, $category,  $detil, $copies, $img, $downloadLink, $reanLink
        // $this->id = $id;
        // $this->title = $title;
        // $this->author = $author;
        // $this->year = $year;
        // $this->category = $category;
        // $this->downloadLink = $downloadLink;
        // $this->readLink = $reanLink;
    }
    //   <-------- اضافة البحث-------->
        public function searchDigiBooks($books){
            $sql = "SELECT * FROM books WHERE bookType = 'Digi' AND title LIKE? OR author LIKE?";
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                throw new Exception('Error preparing query: '. $this->conn->error);
            }
            $books = '%' . $books. '%';
            $stmt->bind_param('ss',  $books, $books);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);

        }
    //   <//-------- اضافة البحث--------//>
    
    public function downloadBook(){
        echo 'Download link: '. $this->downloadLink. '<br>';
    }
    public function readBookLink(){
        echo 'Read online link: '.$this->readLink . '<br>';
    }
    public function displayDetails(){
        // parent::displayDetails();
        echo 'العنوان:' .$this->title .'<br>';
        echo 'المؤلف:' .$this->author .'<br>';
        echo 'سنة النسر: ' .$this->year .'<br>';
        echo 'التصنيف: ' .$this->category .'<br>';
        echo 'الفاصيل: ' .$this->detil .'<br>';
        echo 'النسخ: ' .$this->copies .'<br>';
        echo 'الصورة: ' .$this->img .'<br>';
        // echo ': ' .$this .'<br>';
        echo 'Download link: '. $this->downloadLink. '<br>';
        echo 'Read online link: '.$this->readLink . '<br>';
    }
    public function isBookExists($title){
        $query ="SELECT COUNT(*)  AS count FROM books WHERE title = ?";
        var_dump($query);
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            // عرض خطأ mysqli إذا فشل التحضير
            echo "Failed to prepare statement: " . $this->conn->error;
            return false;
        }
        // var_dump($stmt);
        $stmt->bind_Param('s', $title);
        $stmt->execute();

                // الحصول على النتيجة
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        // إرجاع true إذا كان الكتاب موجودًا
        return $row['count'] > 0;
    }
    public function addDigiBook($title, $author, $year, $categoryName, $detil, $copies=5, $img, $bookType, $downloadLink, $readLink){
        $sql = "INSERT INTO books (title, author, year, category, detil, copies, image, bookType, downloadLink, readLink) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        // echo "<pre>";
        // var_dump($sql);
        // echo "</pre>";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('sssssissss', $title, $author, $year, $categoryName, $detil, $copies, $bookType, $img,  $downloadLink, $readLink);
       $stmt->execute();
       echo 'تم إضافة االكتاب.';
       header( "REFRESH:3; URL = addBook.php");
       return TRUE;
    }
    public function getDigiBooks(){
        $sql = "SELECT * FROM books WHERE bookType ='Digi'";
        $result = mysqli_query($this->conn, $sql);
        if ($result) {
            return $result;
        }else{
            return false;
        }
    }
    }
//     $newBook1 = new Book($conn);
//     $newBook = new DigitalBook($conn, $id = 1,
//      $title = "gh", $author = "gg", $year = "ff",
//          $categoryName ="gg", $detil = "fg", $copies =5,
//           $img = 'ff',  
//           $downloadLink = "ttgg", $readLink = "ttrr");
//     $title = "عنوان";
//      $author = "طالب"; $year = 2055;
//       $categoryName = "جديد";
//       $detil = "لاباايلاباصثةثصيث يصبل";
//         $copies = 5;
//        $img = "صورة";
//        $bookType = "ورقي";
//       $downloadLink = "Link";
//      $readLink = "Link";
//      if ($bookType == "ورقي1") {
//         # code...
//         $newBook->addDigiBook();
//      }else{
//       $newBook1->addBook($title,  $author,  $year, $categoryName, $detil,  $copies ,  $img ,$bookType);
//      }
//    echo "<pre>";
//    var_dump($newBook);
//    echo "</pre>";
// $Digibook = new DigitalBook($conn);
// echo '<pre>';
// var_dump($Digibook->searchDigiBooks("author"));
// echo '</pre';
    ?>