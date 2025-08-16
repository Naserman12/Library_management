<?php
include 'Book.php';

$book = new Book($conn);

if (isset($_GET['search'])) {
    $seachTerm = $_GET['search'];
    $result = $book->searchBooks($seachTerm);
}
?>
 <form action="search.php" method="GET">
          <input type="search" name="search" placeholder="ادخل كلمة البحث..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
          <a href="search.php">بحث</a>
 </form>
        <?php if(!empty($result)): ?>
            <ul>
                <?php foreach ($result as $book): ?>
                <li>
                    <?php echo  $book['title']. 'By'. $book['author'];?>
                </li>  
                <?php endforeach; ?>          
            </ul>
        <?php  endif; ?>