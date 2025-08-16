<style>
    .news-ticker, .latest-additions {
    background-color: #f8f9fa;
    padding: 10px;
    border: 1px solid #dee2e6;
    margin-bottom: 20px;
}

.news-ticker h2, .latest-additions h2 {
    margin: 0 0 10px;
}

.news-ticker ul, .latest-additions ul {
    list-style: none;
    padding: 0;
}

.news-ticker li, .latest-additions li {
    margin-bottom: 5px;
    
}

</style>
<?php
include '../include/db_connect.php';

function get_best_books($conn){
$sql = 'SELECT id, title, author, created_at 
FROM books
WHERE is_featured = 1
ORDER BY created_at DESC
LIMIT 3
';
$result = $conn->query($sql);

if ($result === false) {
    // عرض رسالة خطأ إذا فشل الاستعلام
    echo "خطأ في الاستعلام: " . $conn->error;
}
if ($result->num_rows > 0) {
    $featuredBook =[];
    echo "<div class='news-ticker'>";
    echo "<h2>أفضل الكتب:</h2>";
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        $featuredBook[] = $row;
        echo "<li>";
        echo "عنوان الكتاب: " . $row['title'] . " | المؤلف: " . $row['author'];
        echo "</li>"; 
    }
    echo "</ul>";
    echo "</div>";
}else {
    echo "لا توجد كتب مميزة.";
}

}
function lastAdded($conn){
    $sql_latest = "
    SELECT id, title, author, created_at 
    FROM books 
    ORDER BY created_at DESC 
    LIMIT 3
";
$result = $conn->query($sql_latest);
if ($result === false) {
     // عرض رسالة خطأ إذا فشل الاستعلام
     echo "خطأ في الاستعلام: " . $conn->error;
}
if ($result->num_rows > 0) {
    $featuredBook =[];
    echo "<div class='latest-additions'>";
    echo "<h2>آخر الإضافات:</h2>";
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        $featuredBook[] = $row;
        echo "<li>";
        echo "عنوان الكتاب: ". $row["title"] . "| المؤلف: " .$row['author'];
        echo "</li>";
    }
}

}
get_best_books($conn);
lastAdded($conn);
?>