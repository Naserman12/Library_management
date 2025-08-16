<style>
    body{
        margin: 0;
        padding: 0;
        text-align: center;
        background-color: wheat;
        color: #333;
        
    }
    </style>
<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملخص المكتبة</title>
</head>
<body>
    <h1>ملخص المكتبة</h1>
    <?php
include '../include/db_connect.php';

class Book_reports {
    public $conn;
       public function __construct($db) {
        $this->conn = $db;
         }
         
         public function get_available_books(){
             $sql = 'SELECT COUNT(*) AS available_books FROM books WHERE id NOT IN (SELECT book_id FROM borrow_records WHERE return_date IS NULL)';
             $result = $this->conn->query($sql);
             $categories = array();
                if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                $categories[] = $row; #تخزين التصنيفات في مصفوفة
                // echo "<pre>";
                // print_r($categories);
                // echo "</pre>";
                echo '<h3>  عدد الكتب المتاحة: '.   $categories[0]['available_books'];
                echo '<h3><br><hr>';
            }
                // return $result;
            }else{
                echo"<h3>لا توجد تصنيفات.<h3>";
            }
                return $categories;
                
            
            }
             //  <--//======استعلام عدد الكتب المستعارة======//-->
             public function get_borrow_books(){
                 $sql = 'SELECT COUNT(*) AS borrow_records FROM borrow_records WHERE return_date  IS NULL';
                 $result = $this->conn->query($sql);
                 $categories = array();
                    if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                    $categories[] = $row; #تخزين التصنيفات في مصفوفة
                    // echo "<pre>";
                    // print_r($categories);
                    // echo "</pre>";
                    echo '<h3>  عدد الكتب المستعارة: '.   $categories[0]['borrow_records'].'<h3>';
                    echo '<br><hr>';
                }
                // return $result;
                }else{
                    echo"<h3>لا توجد تصنيفات.<h3><br>";
                }
                return $categories;
                
                
            }
            //  <--//======استعلام عدد الكتب المستعارة======//-->
            //  <--======استعلام الكتب الاكثر ااستعارة======-->
            public function get_best_borrow_books(){
                $sql = 'SELECT books.title, books.image ,  COUNT(borrow_records.book_id) AS borrow_count FROM books
                  JOIN borrow_records ON books.id = borrow_records.book_id
                  GROUP BY borrow_records.book_id
                  ORDER BY borrow_records.book_id
                  LIMIT 5';
                 $result = $this->conn->query($sql);
                 
                 if($result->num_rows > 0){
           
                     echo '<h1>الكتب الأكثر استعارة : <h1><hr>';
                 
                     while($book = $result->fetch_assoc()){
                         echo '<h3>'. $book['title'] . ' - عدد مرات الإستعارة: '. $book['borrow_count'] . "<img src=".$book['image']." alt='صورة الكتاب' width='100' height='90' >"  ."<h3><br>";
                        }
                        echo '<br><hr>';
                    
                  }else{
                    echo "لا توجد نتائج.";
                }   
            }
            //  <--//======استعلام الكتب الاكثر ااستعارة======//-->
            //  <--======استعلام الكتب الاقل ااستعارة======-->
            public function get_low_borrow_books(){
                $sql = 'SELECT books.title,  COUNT(borrow_records.book_id) AS borrow_count FROM books
                  JOIN borrow_records ON books.id = borrow_records.book_id
                  GROUP BY borrow_records.book_id
                  ORDER BY borrow_count ASC
                  LIMIT 3';
                 $result = $this->conn->query($sql);
                //  echo "<pre>";
                //  print_r($result);
                //  echo "</pre>";
                if($result->num_rows > 0){
                    echo '<h2>الكتب الأقل استعارة <h2><br>';
                    echo '<br><hr>';
                    while($book = $result->fetch_assoc()){
                        echo '<h3>'. $book['title'] . ' - عدد مرات الإستعارة ' . $book['borrow_count'] . "<h3><br>";
                    }
                    
                    echo '<br><hr>';
                  }else{
                    echo "<h2>لا توجد نتائج.<h2>";
                }
                
               
            }
            //  <--//======استعلام الكتب الاقل ااستعارة======//-->

            // <--============تقارير الاعضاء===========-->
            
            // <--=======عدد الاعضاء المسجلين في النظام======-->
            public function get_All_members(){

                $sql = "SELECT COUNT(*) AS total_members FROM member WHERE role='members'";
                $result = $this->conn->query($sql);
                if($result->num_rows > 0){
                    $row = $result->fetch_assoc();
                    echo "<h3>عدد الأعضاء المسجلين :".$row['total_members'].'<h3><br><hr>';
                }
            }
            // <--//=======عدد الاعضاء المسجلين في النظام======//-->
            // <--=======العضو االاكثر استعارة للكتب======-->
            public function get_most_active_members(){
                $sql = 'SELECT member.name, COUNT(borrow_records.member_id) AS borrow_count
                FROM member
                JOIN borrow_records ON member.id = borrow_records.member_id
                GROUP BY borrow_records.member_id
                ORDER BY borrow_count DESC
                LIMIT 3
                ';
                $result = $this->conn->query($sql);
                if($result->num_rows > 0){
                    echo "<h1>الأعضاء الأكثر نشاطا.<h1><br>";
                    while($row = $result->fetch_assoc()){
                        echo '<h3>العضو: '. $row["name"] . " عدد مرات الإستعارة: ". $row["borrow_count"].' <h3><br>';
                    }
                    echo '<hr>';
                }else{
                    echo "<h3>لا توجد سجلات .</h3>";
                }
            }
            // <--//=======العضو االاكثر استعارة للكتب======//-->
            // <--=======الاعضاؤ الذين لديهم مستعارة حاليا======-->
            public function get_members_with_borrowed_books(){
                $sql = "SELECT member.name, COUNT(borrow_records.member_id) AS borrowed_books_count 
                FROM member
                JOIN borrow_records ON member.id = borrow_records.member_id
                WHERE borrow_records.return_date IS NULL
                GROUP BY borrow_records.member_id
                ";
                $result = $this->conn->query($sql);
                if($result->num_rows > 0){
                    echo "<h1>الأعضاء الذين لديهم كتب مستعارة.</h1><br><hr>";
                    // echo "<br><hr>";
                    while($row = $result->fetch_assoc()){
                        echo '<h3> '. $row["name"] . " عدد الكتب المستعارة: ". $row["borrowed_books_count"].' </h3><br>';
                    }
                    echo "<br><hr>";
                }else{
                    echo "<h3>لا توجد كتب مستعارة الان.</h3>";
                }
            }
            // <--//=======الاعضاؤ الذين لديهم مستعارة حاليا======//-->
            public function get_members_without_borrow() {
                $sql = "SELECT member.name
                FROM member
                LEFT  JOIN borrow_records ON member.id = borrow_records.member_id
                WHERE borrow_records.member_id IS NULL
                ";
                 $result = $this->conn->query($sql);
                    if($result->num_rows > 0){
                        echo "<h1>الأعضاء الذين لم يقوموا بأي استعارة: </h2> <br><hr>";
                        while($row = $result->fetch_assoc()){
                            echo '<h3>==== '. $row["name"] . " ====<br></h3>";
                        }
                    }else{
                        echo "<h3>لا توجد بيانات.</h3>";
                    }
                

            }
            // <--========الأعضاء الذين لم يقوموا بأي استعارة=======-->
            // <--//============تقارير الاعضاء===========//-->
        }
$reports = new Book_reports($conn);
$reports->get_available_books();
$reports->get_borrow_books();
$reports->get_best_borrow_books();
$reports->get_low_borrow_books();
$reports->get_all_members();
$reports->get_most_active_members();
$reports->get_members_with_borrowed_books();
$reports-> get_members_without_borrow();
?>
    
</body>
</html>

