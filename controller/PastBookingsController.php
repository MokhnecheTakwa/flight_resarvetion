<?php
require_once '../Model/resarvetion.php';
require_once '../confi/db.php';

session_start();

// تأكد من أن المستخدم مسجل دخول
if (!isset($_SESSION['client_id'])) {
    header("Location: ../View/client/login.php");
    exit;
}

$reservation = new Reservation($pdo);
$client_id = $_SESSION['client_id'];
$pastBookings = $reservation->getPastBookings($client_id);

// أرسل البيانات إلى الـ View
include '../View/resarvetion/pastbookings.php';
?>

