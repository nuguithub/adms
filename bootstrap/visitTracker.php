<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<html>

<head>
    <script>
    window.onload = function() {
        setTimeout(function() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "update_visit.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    var visitCount = xhr.responseText;
                    document.getElementById("visitCount").innerHTML = "Visit Counts: " + visitCount;
                }
            };
            xhr.send();
        }, 10000); // 10 seconds in milliseconds
    };
    </script>
</head>

<body>
    <p id="visitCount">Visit Counts: <?php echo ($row['visit_count'] ?? '0'); ?></p>
</body>

</html>