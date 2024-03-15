<!DOCTYPE html>
<html>

<head>
    <title>Loading Page</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.png">
    <link rel="stylesheet">
    <style>
    body {
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f2f2f2;
    }

    .loading-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .loading-spinner {
        border: 10px solid rgba(0, 0, 0, 0.3);
        border-top: 10px solid #09ad0e;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
    </style>
</head>

<body>
    <div class="loading-container">
        <div class="loading-spinner"></div>
    </div>

    <script>
    setTimeout(function() {
        window.location.href = 'dashboard.php';
    }, 500);
    </script>
</body>

</html>