<?php
require_once 'connectDB.php';


if (isset($_GET['id'])) {
    $wId = intval($_GET['id']);

    $sql = "DELETE FROM workHistory WHERE work_id = $wId";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Work experience deleted.'); 
        setTimeout(function() { window.location.href = 'profile.php'; }, 1000);
        </script>";
                    
    } else {
        echo "<script>alert('Failed to delete work experience.'); 
       setTimeout(function() { window.location.href = 'profile.php'; }, 1000);
        </script>";
    }
}

$conn->close();
?>