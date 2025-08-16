<?php
// بناء جلسة
session_start();
// حدف لكل المنشن التي تم حفظها داخل الموقع
session_unset();
// تدمير الجلسة
session_destroy();

// اعادة توجيه المستخدم

header( 'location:../index.php');
mysqli_close($conn);
?>