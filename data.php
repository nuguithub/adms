<?php
$host = 'localhost';
$dbname = 'adms';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch number of visits
    // $visitsQuery = $pdo->query("SELECT month, visits FROM visits_data");
    // $visitsData = $visitsQuery->fetchAll(PDO::FETCH_ASSOC);

    // Fetch total number of graduates
    $graduatesQuery = $pdo->query("SELECT coll_dept_id, fname FROM alumni");
    $graduatesData = $graduatesQuery->fetchAll(PDO::FETCH_ASSOC);

    $data = [
        // 'visits' => $visitsData,
        'alumni' => $graduatesData
    ];

    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>