<?php
include '../admin/login.php';

$member = new member($conn);
$member->email = "m@m";
$member->password = "0";
// session_start();
// if(isset($_SESSION['id'])){
    // $member_id = $_SESSION['id'];
    // $member->login( "m@m", "0");
// $member_id = 3;
// $sql = 'SELECT * FROM borrow_records WHERE member_id = :member_id';
// $stmt = $conn->prepare($sql);
// $stmt->execute(['member_id' => $member_id]);
$result = $stmt->fetch();
var_dump($result);
// }
?>