<?php
class Client {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // دالة التسجيل
    public function register($firstName, $lastName, $email, $password) {
        // التحقق من أن كلمة المرور تحتوي على 8 شيفرات مختلطة
        if (!$this->validatePassword($password)) {
            // إذا كانت كلمة المرور غير صالحة، إعادة قيمة خاطئة
            return false;
        }
    
        // تشفير كلمة المرور
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
   
        // الاستعلام لإدخال بيانات العميل في قاعدة البيانات
        $sql = "INSERT INTO client (first_name, last_name, email, password)
                VALUES (?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$firstName, $lastName, $email, $hashedPassword]);
    }
    
    // دالة التحقق من كلمة المرور
    private function validatePassword($password) {
        // تعبير منتظم للتحقق من أن كلمة المرور تحتوي على 8 شيفرات مختلطة بين الأحرف والأرقام والرموز
        $regex = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        return preg_match($regex, $password); // إرجاع true إذا كانت كلمة المرور صالحة
    }
    

    // ✅ دالة تسجيل الدخول
    public function loginWithEmail($email, $password) {
        $sql = "SELECT client_id, first_name, last_name, email, password, role FROM client WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        $_SESSION['client_id'] = $user['client_id'];

    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // طباعة المتغير لتتأكد من البيانات
        var_dump($user);
    
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
    
        return false;
    }
      
    public function getClientById($clientId) {
        $sql = "SELECT * FROM client WHERE client_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$clientId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ دالة التحديث
    public function updateClient($clientId, $firstName, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE client SET first_name = ?, email = ?, password = ? WHERE client_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$firstName, $email, $hashedPassword, $clientId]);
    }


    }

?>



