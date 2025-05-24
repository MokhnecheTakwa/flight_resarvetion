<?php
session_start();
session_unset();
session_destroy(); // تدمير الجلسة

// إعادة توجيه إلى صفحة logout.php التي ستعرض تصميم logout.html
header("Location: ../View/client/logout.php");
exit();
