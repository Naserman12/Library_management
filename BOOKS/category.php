<?php
// include_once '../include/db_connect.php'; // اتصال PDO
include_once 'Book.php';

class category {
    private $conn;
    public $id;
    public $name;
    public $table = 'categories';

    public function __construct($db){
        $this->conn = $db; // PDO
    }

    // ============================
    // جلب جميع التصنيفات
    // ============================
    public function getCaty(){
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($categories)) {
            echo "لا توجد تصنيفات.";
        }

        return $categories;
    }

    // ============================
    // جلب تصنيف حسب ID
    // ============================
    public function getCategoryById($id){
        $query = "SELECT name FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ============================
    // تعديل تصنيف
    // ============================
    public function updateCategory($name, $id){
        $query = "UPDATE " . $this->table . " SET name = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $id, PDO::PARAM_INT);

        $stmt->execute();
    }

    // ============================
    // حفظ تصنيف جديد
    // ============================
    public function saveCaty($name){
        // تحقق من وجود الاسم مسبقًا
        $query = "SELECT * FROM categories WHERE name = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $name);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo 'يوجد تصنيف بنفس الاسم.';
            header("REFRESH:2; URL=../admin/adminpanel.php");
            return false;
        }

        // إضافة التصنيف
        $query = "INSERT INTO categories (name) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $name);

        if ($stmt->execute()) {
            echo 'تم إضافة التصنيف بنجاح';
            header("REFRESH:2; URL=../admin/adminpanel.php");
            return true;
        } else {
            echo 'حدث خطأ لم يتم الإضافة';
            header("REFRESH:3; URL=../admin/adminpanel.php");
            return false;
        }
    }

    // ============================
    // حذف تصنيف
    // ============================
    public function deleteCaty($id){
        $query = "DELETE FROM categories WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo 'تم حذف التصنيف';
            header("REFRESH:2; URL=../admin/adminpanel.php");
        } else {
            echo 'لم يتم حذف التصنيف.';
            header("REFRESH:2; URL=../admin/adminpanel.php");
        }
    }
}
?>
