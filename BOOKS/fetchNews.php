<?php

require_once '../include/init.php';

function fetchingNews($conn)
{
    header('Content-Type: application/json; charset=utf-8');

    try {

        // =========================================
        // افضل الكتب
        // =========================================
        $featuredSql = "SELECT id, title, author, image, created_at
                        FROM books
                        WHERE is_featured = 1
                        ORDER BY created_at DESC
                        LIMIT 3";

        $featuredStmt = $conn->prepare($featuredSql);
        $featuredStmt->execute();

        $books = $featuredStmt->fetchAll(PDO::FETCH_ASSOC);

        // =========================================
        // آخر الإضافات
        // =========================================
        $latestSql = "SELECT id, title, author, image, created_at
                      FROM books
                      ORDER BY created_at DESC
                      LIMIT 5";

        $latestStmt = $conn->prepare($latestSql);
        $latestStmt->execute();

        $latestBooks = $latestStmt->fetchAll(PDO::FETCH_ASSOC);

        // =========================================
        // تجهيز البيانات
        // =========================================
        $newsData = [
            [
                "type" => "أفضل الكتب",
                "content" => []
            ],
            [
                "type" => "آخر الإضافات",
                "content" => []
            ]
        ];

        // الكتب المميزة
        foreach ($books as $book) {

            $newsData[0]['content'][] = [
                "id" => $book['id'],
                "title" => $book['title'],
                "author" => $book['author'],
                "image" => $book['image'],
                "created_at" => $book['created_at']
            ];
        }

        // أحدث الكتب
        foreach ($latestBooks as $book) {

            $newsData[1]['content'][] = [
                "id" => $book['id'],
                "title" => $book['title'],
                "author" => $book['author'],
                "image" => $book['image'],
                "created_at" => $book['created_at']
            ];
        }

        // إرسال JSON
        echo json_encode([
            "success" => true,
            "newsData" => $newsData
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    } catch (PDOException $e) {

        http_response_code(500);

        echo json_encode([
            "success" => false,
            "message" => $e->getMessage()
        ], JSON_UNESCAPED_UNICODE);
    }
}

// تشغيل الدالة
fetchingNews($conn);
?>