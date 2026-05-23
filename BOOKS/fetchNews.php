<?php
include '../include/db_connect.php';

function fetchingNews($conn)
{
    header('Content-Type: application/json; charset=utf-8');

    // 1) افضل الكتب
    $sql = "SELECT id, title, author, image, created_at 
            FROM books 
            WHERE is_featured = 1 
            ORDER BY created_at DESC 
            LIMIT 3";

    $result = $conn->query($sql);

    if ($result === false) {
        http_response_code(500);
        echo json_encode(["error" => $conn->error]);
        exit;
    }

    $books = [];
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }

    // 2) آخر الإضافات
    $sql = "SELECT id, title, author, image, created_at 
            FROM books 
            ORDER BY created_at DESC 
            LIMIT 5";

    $result = $conn->query($sql);

    if ($result === false) {
        http_response_code(500);
        echo json_encode(["error" => $conn->error]);
        exit;
    }

    $latestBooks = [];
    while ($row = $result->fetch_assoc()) {
        $latestBooks[] = $row;
    }

    // 3) بناء JSON
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

    foreach ($books as $book) {
        $newsData[0]['content'][] = [
            "title" => $book['title'],
            "author" => $book['author']
        ];
    }

    foreach ($latestBooks as $book) {
        $newsData[1]['content'][] = [
            "title" => $book['title'],
            "author" => $book['author']
        ];
    }

    echo json_encode([
        "newsData" => $newsData
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

fetchingNews($conn);
// $conn->close();