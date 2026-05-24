<?php
require_once '../include/session.php';
include '../include/db_connect.php'; // اتصال PDO

function get_best_books($conn) {

    $sql = "SELECT id, title, author, created_at 
            FROM books
            WHERE is_featured = 1
            ORDER BY created_at DESC
            LIMIT 3";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($rows) > 0) {
        echo "<div class='news-ticker'>";
        echo "<h2>أفضل الكتب:</h2>";
        echo "<ul>";

        foreach ($rows as $row) {
            echo "<li>عنوان الكتاب: {$row['title']} | المؤلف: {$row['author']}</li>";
        }

        echo "</ul>";
        echo "</div>";
    } else {
        echo "<div class='news-ticker'>لا توجد كتب مميزة.</div>";
    }
}

function lastAdded($conn) {

    $sql = "SELECT id, title, author, created_at 
            FROM books 
            ORDER BY created_at DESC 
            LIMIT 3";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($rows) > 0) {
        echo "<div class='latest-additions'>";
        echo "<h2>آخر الإضافات:</h2>";
        echo "<ul>";

        foreach ($rows as $row) {
            echo "<li>عنوان الكتاب: {$row['title']} | المؤلف: {$row['author']}</li>";
        }

        echo "</ul>";
        echo "</div>";
    } else {
        echo "<div class='latest-additions'>لا توجد إضافات جديدة.</div>";
    }
}

get_best_books($conn);
lastAdded($conn);
?>
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