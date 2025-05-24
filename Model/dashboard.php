<?php
// Model/dashboard.php

class DashboardModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getUserInfo($clientId) {
        $stmt = $this->pdo->prepare("SELECT first_name, last_name FROM client WHERE client_id = ?");
        $stmt->execute([$clientId]);
        return $stmt->fetch();
    }
    $_SESSION['role'] = $client['role']; // إضافته للجلسة إن لم يكن موجودًا

}
?>
