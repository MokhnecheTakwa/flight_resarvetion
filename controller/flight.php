<?php
require_once '../Model/flight.php';
require_once '../confi/db.php'; // التأكد من الاتصال بقاعدة البيانات

$flight = new Flight($pdo);

$action = $_GET['action'] ?? 'List';

if ($action == 'List') {
    // جلب جميع الرحلات
    $flights = $flight->getAllFlights();
    require_once '../View/flights/List.php';

} elseif ($action == 'details' && isset($_GET['flight_number'])) {
    // جلب تفاصيل الرحلة باستخدام رقم الرحلة
    $flightNumber = $_GET['flight_number'];
    $flightDetails = $flight->getFlightByNumber($flightNumber);

    if ($flightDetails) {
        require_once '../View/flights/details.php';
    } else {
        echo "الرحلة غير موجودة.";
    }

} elseif ($action == 'search' && isset($_GET['from'], $_GET['to'], $_GET['departure_date'])) {
    // التقاط البيانات القادمة من نموذج البحث
    $from = $_GET['from'];
    $to = $_GET['to'];
    $date = $_GET['departure_date'];
    $tripType = $_GET['trip_type'] ?? 'oneway';
    $class = $_GET['class'] ?? 'Economy';
    // حساب عدد الركاب من الحقول المختلفة
    $adults = isset($_GET['adults']) ? (int)$_GET['adults'] : 1;
    $children = isset($_GET['children']) ? (int)$_GET['children'] : 0;
    $infants = isset($_GET['infants']) ? (int)$_GET['infants'] : 0;
    $passengers = $adults + $children + $infants;

    // استدعاء دالة البحث بدون معيار الكلاس
    $flights = $flight->searchFlights($from, $to, $date, $tripType, $passengers);
    require_once '../View/flights/List.php';
}
?>














