<?php
require_once '../../connectDB.php';

if (isset($_GET['alumni_id'])) {
    $alId = intval($_GET['alumni_id']);

    $delSql = "SELECT img FROM alumni WHERE alumni_id = $alId";
    $result = mysqli_query($conn, $delSql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Check if img is not null before proceeding with deletion
        if ($row['img'] !== null) {
            $imgFilePath = '../../img/alumni/' . $row['img'];

            if (file_exists($imgFilePath) && unlink($imgFilePath)) {
                // Proceed with deletion only if the file deletion is successful

                $sql = "DELETE FROM alumni WHERE alumni_id = $alId";

                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Alumni deleted.');
                    setTimeout(function() { window.location.href = '../alumni-directory.php'; }, 1000);
                    </script>";

                } else {
                    echo "<script>alert('Failed to delete Alumni.');
                    setTimeout(function() { window.location.href = '../alumni-directory.php'; }, 1000);
                    </script>";
                }
            } else {
                echo "<script>alert('Failed to delete Alumni image.');
                setTimeout(function() { window.location.href = '../alumni-directory.php'; }, 1000);
                </script>";
            }
        } else {
            // If img is null, proceed with deletion without checking the file
            $sql = "DELETE FROM alumni WHERE alumni_id = $alId";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Alumni deleted.');
                setTimeout(function() { window.location.href = '../alumni-directory.php'; }, 1000);
                </script>";

            } else {
                echo "<script>alert('Failed to delete Alumni.');
                setTimeout(function() { window.location.href = '../alumni-directory.php'; }, 1000);
                </script>";
            }
        }
    } else {
        echo "<script>alert('Failed to delete Alumni.');
        setTimeout(function() { window.location.href = '../alumni-directory.php'; }, 1000);
        </script>";
    }
}

?>