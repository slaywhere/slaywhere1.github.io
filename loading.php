<?php
session_start();
$user_ip = $_SERVER['REMOTE_ADDR']; // Get the user's IP address
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading...</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .loader {
            border: 8px solid #f3f3f3;
            border-radius: 50%;
            border-top: 8px solid #3498db;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <script>
        const userIp = "<?php echo $user_ip; ?>"; // Pass IP address to JavaScript

        async function checkRedirect() {
            console.log("Checking redirect for IP:", userIp);
            try {
                // Pass the user's IP in the URL
                const response = await fetch(`redirect_status.php?ip=${encodeURIComponent(userIp)}`);
                const data = await response.json();
                console.log("Server response:", data);

                if (data.redirect) {
                    console.log("Redirecting to:", data.url);
                    window.location.href = data.url;
                } else {
                    setTimeout(checkRedirect, 1000); // Retry after 1 second
                }
            } catch (error) {
                console.error("Error fetching redirect status:", error);
                setTimeout(checkRedirect, 1000); // Retry after 1 second
            }
        }

        document.addEventListener('DOMContentLoaded', checkRedirect);
    </script>
</head>
<body>
    <div class="loader"></div>
</body>
</html>
