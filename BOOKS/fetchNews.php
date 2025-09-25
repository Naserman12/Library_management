<?php
include '../include/db_connect.php';
function fetchingNews($conn) {
    $sql = "SELECT id, title, author, image, created_at FROM books WHERE is_featured = 1 ORDER BY  created_at DESC LIMIT 3";
 $result = $conn->query($sql);
 if ($result === false){
    die('error !!!!!!!!'. $conn->error);
 }
    if($result->num_rows > 0){
        $books =[];
        while($row = $result->fetch_assoc()){
        $books[] = $row;
        }
    }
        // يمكن جلب المزيد من الكتب (مثلاً آخر 5 كتب عادية)
        $sql = "SELECT id, title, author, image, created_at FROM books ORDER BY created_at DESC LIMIT 5";
        $result = $conn->query($sql);
        
        if ($result === false) {
            die('Error: ' . $conn->error);
        }
        
        $latestBooks = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $latestBooks[] = $row;
            }
        }
        header('Content-Type: application/json');
            // هيكل الأخبار المرسل الى جافا سكريبت
    $newsData = [
        [
            "type" => "افضل الكتب",
            "content" => []
        ]
        ,[
            "type" => "آخر الإضافات",
            "content" => []
        ]
    ];

    // ملء قسم "افضل الكتب" بالكتب المميزة
    foreach ($books as $book) {
        $newsData[0]['content'][] = [
            "title" => $book['title'],
            "author" => $book['author']
           
        ];
    }
        // ملء قسم "آخر الإضافات" بالكتب الأحدث
        foreach ($latestBooks as $book) {
            $newsData[1]['content'][] = [
                "title" => $book['title'],
                "author" => $book['author']
            ];
        }
    echo json_encode(["newsData" =>  $newsData ]);
}
fetchingNews($conn);
    $conn->close();

