<?php
session_start();
require_once '../confi/db.php';
require_once '../Model/client.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['client_id'])) {
    $clientId = $_SESSION['client_id'];
    $firstName = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // تأكد أنك تتحقق منها حسب السياسة
    $client = new Client($pdo);
    $client->updateClient($clientId, $firstName, '', $email, $password);

    header("Location: ../View/client/manageprofile.php?success=1");
    exit();
}
?>
