<?php
require_once '../include/session.php';
require_once '../include/db_connect.php';
?>
<div class="content_sec"> 
  <form action="adminpanel.php" method="GET">
    <!-- تحديث نتائج البحث -->
    <input type="hidden" name="page" value="books">
    <input type="search" name="search" placeholder="ادخل كلمة البحث..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    <button type="submit" name="search_btn">بحث</button>
  </form>
  <?php
  $book = new Book($conn);
$category = new Category($conn);

$result = $book->getBooks();

if ($result) {

    $seachTerm = $_GET['search'] ?? null;

    if ($seachTerm) {

        $books = $book->searchBooks($seachTerm);

        if (!empty($books)) {
?>
            <h1>نتائج البحث</h1>
            <table border="1">
                <thead>
                    <tr>
                        <th>صورة</th>
                        <th>رقم الكتاب</th>
                        <th>العنوان</th>
                        <th>المؤلف</th>
                        <th>سنة النشر</th>
                        <th>النسخ المتاحة</th>
                        <th>تعديل/حذف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td><img src="<?= $book['image']; ?>" width="140" height="150"></td>
                            <td><?= $book['id']; ?></td>
                            <td><?= $book['title']; ?></td>
                            <td><?= $book['author']; ?></td>
                            <td><?= $book['year']; ?></td>
                            <td><?= $book['copies']; ?></td>
                            <td>
                                <a class="edt_btn" href="editBook.php?id=<?= $book['id']; ?>">تعديل</a> |
                                <a onclick="return confirm('هل انت تريد حذف الكتاب؟')" href="deleteBook.php?id=<?= $book['id']; ?>" class="del_btn">حذف</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
<?php
        } else {
            echo "لا توجد نتائج بحث لـ " . $seachTerm;
        }
    }

    // عرض جميع الكتب
    if (!empty($result)) {
?>
        <h1>جميع الكتب</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>صورة</th>
                    <th>رقم الكتاب</th>
                    <th>العنوان</th>
                    <th>المؤلف</th>
                    <th>سنة النشر</th>
                    <th>النسخ المتاحة</th>
                    <th>تعديل/حذف</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $book): ?>
                    <tr>
                        <td><img src="<?= $book['image']; ?>" width="150" height="150"></td>
                        <td><?= $book['id']; ?></td>
                        <td><?= $book['title']; ?></td>
                        <td><?= $book['author']; ?></td>
                        <td><?= $book['year']; ?></td>
                        <td><?= $book['copies']; ?></td>
                        <td>
                          
                            <a class="edt_btn" href="/Library/BOOKS/editBook.php?id=<?= $book['id']; ?>">تعديل</a> |
                            <a onclick="return confirm('هل انت تريد حذف الكتاب؟')" href="/Library/BOOKS/deleteBook.php?id=<?= $book['id']; ?>" class="del_btn">حذف</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
<?php
    }

} else {
    echo "لا توجد كتب لعرضها";
}
?>
