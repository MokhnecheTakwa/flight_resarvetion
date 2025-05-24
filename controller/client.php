
<?php 
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once realpath('../Model/client.php');
echo "Loaded from: " . realpath('../Model/client.php');

require_once '../confi/db.php';

$client = new Client($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'signup') {
        // عملية التسجيل
        if (isset($_POST['username'], $_POST['email'], $_POST['password'])) {
            $username = trim($_POST['username']);
            $email = $_POST['email'];
            $password = $_POST['password'];

            // تقسيم اسم المستخدم إلى أول وآخر
            $nameParts = explode(" ", $username, 2);
            $firstName = $nameParts[0];
            $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

            // التحقق من كلمة المرور (8 أحرف مختلطة بين الأحرف والأرقام والرموز)
            if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
                // إذا كانت كلمة المرور غير صالحة، عرض رسالة خطأ
                echo "كلمة المرور غير صالحة، يجب أن تحتوي على 8 أحرف مختلطة بين الأحرف والأرقام والرموز.";
                exit;
            }

            // استدعاء دالة التسجيل
            $result = $client->register($firstName, $lastName, $email, $password);

            if ($result) {
                echo "تم التسجيل بنجاح!";
            } else {
                echo "فشل في التسجيل.";
            }
        } else {
            echo "يرجى ملء جميع الحقول.";
        }
    }
}



    // عملية تسجيل الدخول (تم تغييرها إلى if منفصلة)
    if (isset($_POST['action']) && $_POST['action'] === 'login') {
        if (isset($_POST['email'], $_POST['password'])) {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            var_dump(get_class_methods($client));

    
            $user = $client->loginWithEmail($email, $password);
            var_dump($user); 

    
            if ($user) {
                $_SESSION['client_id'] = $user['client_id'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['role'] = strtolower($user['role']); // تحويل إلى أحرف صغيرة للمقارنة
                
                if ($_SESSION['role'] === 'admin') {
                    header("Location: ../View/client/Admin_dashbord.php");
                    exit();
                } else {
                    header("Location: ../View/dashboard.php");
                    exit();
                }
            } else {
                $_SESSION['error'] = "البريد الإلكتروني أو كلمة المرور غير صحيحة.";
                header("Location: ../View/client/login.php"); // توجيه مرة أخرى لصفحة تسجيل الدخول
                exit();
            }
        } else {
            $_SESSION['error'] = "يرجى إدخال البريد الإلكتروني وكلمة المرور.";
            header("Location: ../View/client/login.php");
            exit();
        }
    }



?>