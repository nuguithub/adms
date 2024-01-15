<?php
include "../../connectDB.php";

$sql = "SELECT DISTINCT batch FROM alumni_program ORDER BY batch";
$result = mysqli_query($conn, $sql);

$batches = array();
while ($row = mysqli_fetch_assoc($result)) {
    $batches[] = $row['batch'];
}

echo json_encode($batches);
?>