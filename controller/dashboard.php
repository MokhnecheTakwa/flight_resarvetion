<?php
// controller/dashboard.php

class DashboardController {
    public function show() {
        session_start();

        if (!isset($_SESSION['client_id'])) {
            header('Location: index.php?page=login');
            exit();
        }

        require_once 'confi/db.php';
        require_once 'Model/dashboard.php';

        $dashboardModel = new DashboardModel($pdo);
        $client = $dashboardModel->getUserInfo($_SESSION['client_id']);
        $_SESSION['client_name'] = $client['first_name'] . ' ' . $client['last_name'];

        // توجيه المستخدم بناءً على الدور
        if ($_SESSION['role'] === 'admin') {
            require 'View/client/Admin_dashboard.php';
        } else {
            require 'View/dashboard.php';
        }



        require 'View/dashboard.php';
    }
}
case 'pastbookings':
  $pastBookings = Dashboard::getPastBookings($clientId);
  include 'View/pastbookings.php';
  break;
?>
