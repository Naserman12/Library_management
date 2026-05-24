<?php
    // require_once $_SERVER['DOCUMENT_ROOT']. '/include/db_connect.php';
    // require_once __DIR__ . '/../include/db_connect.php';
    // require_once __DIR__ . '/../include/flash.php';
    
    // include 'category.php';
    // <----------كلاس الكتب--------->
    
    class Book{
        private $conn;
        // الخصائص
        public $id
        , $title
        , $author
        , $category
        , $detil
        , $year
        , $copies
        , $img
        , $price;
        public function __call($methode, $params){
                echo "The method [ " .$methode."] Not Found  Or Bot Accessible<br>";
                print_r($params);
        }

        public function __construct($db){
            $this->conn = $db;
    }
    //   <-------- اضافة البحث-------->
        // public function searchBooks($books){
        //     $sql = "SELECT * FROM books WHERE bookType = 'paper' AND title LIKE? OR author LIKE?";
        //     $stmt = $this->conn->prepare($sql);

        //     if ($stmt === false) {
        //         throw new Exception('Error preparing query: '. $this->conn->error);
        //     }
        //     $books = '%' . $books. '%';
        //     $stmt->bind_param('ss',  $books, $books);
        //     $stmt->execute();
        //     $result = $stmt->get_result();
        //     return $result->fetch_all(MYSQLI_ASSOC);
        // }
public function searchBooks($searchTerm) {
    $stmt = $this->conn->prepare("
        SELECT * FROM books 
        WHERE title LIKE :search 
        OR author LIKE :search
    ");

    $stmt->bindValue(':search', "%$searchTerm%", PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
        //   <//-------- اضافة البحث--------//>
// <-------- اضافة كتب-------->
// public function addBook($title, $author, $year, $categoryName, $detil, $copies, $img, $bookType){
//     // var_dump($category_id);
//     $sql = "INSERT INTO books (title, author, year, category, detil,  copies, image, bookType) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
//      $stmt = $this->conn->prepare($sql);
//     $stmt->bind_param('sssssiss', $title, $author, $year, $categoryName, $detil, $copies, $img, $bookType);
    
//     $stmt->execute();
    
//     return true;
// }
public function addBook($title, $author, $year, $categoryName, $detil, $copies, $img, $bookType){

    $sql = "INSERT INTO books 
    (title, author, year, category, detil, copies, image, bookType)
    VALUES (:title, :author, :year, :category, :detil, :copies, :img, :bookType)";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([
        ':title' => $title,
        ':author' => $author,
        ':year' => $year,
        ':category' => $categoryName,
        ':detil' => $detil,
        ':copies' => $copies,
        ':img' => $img,
        ':bookType' => $bookType
    ]);

    return true;
}
    //   <--//-------- اضافة كتب--------//-->
    //   <-------- تعديل الكتب--------->
    //   public function updateBook( $title, $author, $category, $year, $detil, $copies,  $img, $id){
    //      $query ="UPDATE books SET title=?, author=?, category=?, year=?, detil=?, copies=?, image=? where id=?";  ##"UPDATE  books SET title='$title', author=' $author', category='$category', year='$year', copies=$copies, image='$img'";## 
    //     echo $query;
    //     $stmt = $this->conn->prepare($query);
    //     if ($stmt->affected_rows === null) {
    //         // echo '$stmt Doing..';
    //         throw new Exception('Error preparing query: '. $this->conn->error);
    //     }
    //     // var_dump($stmt ) ;
    //     $stmt->bind_param("sssssisi", $title, $author, $category, $year,$detil, $copies, $img, $id) ;
    //     $stmt->execute();
    //     if (!$stmt->execute()) {
    //         throw new Exception("'errror'". $this->conn->error);
    //     }

    //     $stmt->execute();
    //     return true;
    //     // if ($stmt->affected_rows === null) {
    //     //     // echo '$stmt Doing..';
    //     //     throw new Exception('Error preparing query: '. $stmt->error);
    //     // }
    //     }
    public function updateBook($title, $author, $category, $year, $detil, $copies, $img, $id){

    $sql = "UPDATE books SET 
        title = :title,
        author = :author,
        category = :category,
        year = :year,
        detil = :detil,
        copies = :copies,
        image = :image
        WHERE id = :id";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([
        ':title' => $title,
        ':author' => $author,
        ':category' => $category,
        ':year' => $year,
        ':detil' => $detil,
        ':copies' => $copies,
        ':image' => $img,
        ':id' => $id
    ]);

    return true;
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
        // public function getBooks(){
        //     $query = "SELECT * FROM books";
        //     $result = mysqli_query($this->conn, $query);
        //     return $result;
        // }
        public function getBooks() {
            $stmt = $this->conn->prepare("SELECT * FROM books");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    //   <--//------عرض الكتب -------//-->

    // <------جلب معرف الكتب------->
// public function getBook($id) {
//   // تحضير الاستعلام لجلب الكتاب بناءً على المعرف
//   $query = "SELECT * FROM books WHERE id = ?";
//   $stmt = $this->conn->prepare($query);
// // ربط المتغيرات
// $stmt->bind_param("i", $id);
// // تنفيذ الاستعلام
// $stmt->execute();
// $result = $stmt->get_result();
// return $result->fetch_assoc();
// // التحقق من وجود البيانات
// }
public function getBook($id) {
    $stmt = $this->conn->prepare("SELECT * FROM books WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
// <//------جلب معرف الكتب-------//>
// <---------جلب جميع الكتب-------->
      public function getAllBooks(){
        $query = " SELECT books.id, books.title, books.author, books.year,
         books.copies, caategoty.name AS category FROM 
        ". $this->conn. "LEFT JOIN categories ON books.category_id = category.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
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
    }
    //   <-------- اضافة البحث-------->
        public function searchDigiBooks($books){
            $sql = "SELECT * FROM books WHERE bookType = 'Digi' AND title LIKE? OR author LIKE?";
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                throw new Exception('Error preparing query: '. $this->conn->error);
            }
            $books = '%' . $books. '%';
            $stmt->execute([
                ':search' => $books
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;

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
    $query = "SELECT COUNT(*) AS count FROM books WHERE title = ?";
    $stmt = $this->conn->prepare($query);

    // ربط المتغير
    $stmt->bindParam(1, $title, PDO::PARAM_STR);

    // تنفيذ
    $stmt->execute();

    // جلب النتيجة
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row['count'] > 0;
}

public function addDigiBook($title, $author, $year, $categoryName, $detil,  $img, $bookType, $downloadLink, $readLink, $copies = 5,)
{
    $sql = "INSERT INTO books 
            (title, author, year, category, detil, image, bookType, downloadLink, readLink, copies) 
            VALUES (:title, :author, :year, :category, :detil, :img, :bookType, :downloadLink, :readLink, :copies)";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([
        ':title'        => $title,
        ':author'       => $author,
        ':year'         => $year,
        ':category'     => $categoryName,
        ':detil'        => $detil,
        ':img'          => $img,
        ':bookType'     => $bookType,
        ':downloadLink' => $downloadLink,
        ':readLink'     => $readLink,
        ':copies'       => $copies
    ]);

    return true;
}

    public function getDigiBooks(){
        $sql = "SELECT * FROM books WHERE bookType ='Digi'";
        $result = $this->conn->prepare($sql);
        $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    }

    // Testing
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