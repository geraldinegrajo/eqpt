<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Equipment Management System</title>
    <style>
        /* Body Styles */
        body {
            background-image: url('https://thumbs.dreamstime.com/z/cybernetic-data-analytics-computer-science-future-coding-wallpaper-ai-robot-algorithms-155190397.jpg');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            color: #006400;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        /* Header Styles */
        h1 {
            padding: 12px;
            margin: 25px auto;
            border: 18px solid #716713;
            border-radius: 15px;
            width: 350px;
            font-weight: bold;
            font-size: 60px;
            margin-top: 35px;
            color: #802306;
        }

        /* Login Box */
        .login-box {
            width: 350px;
            padding: 45px;
            margin: 100px auto;
            background-color: url('https://wallpaperaccess.com/full/1623278.jpg');
            border: 2px solid #006400;
            border-radius: 25px;
            border: 18px solid #716713;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

                /* Input Fields */
        .login-box input {
            width: 75%;
            padding: 12px;
            margin: 15px 0;
            border: 3px solid #802306;
            border-radius: 15px;
            font-size: 16px;
            font-weight: bold;
            color: #006400;
            color: black;
            background-color: #C781A4;
        }

            .login-box input[type="submit"] {
            background-color: #C781A4;
            color: black;
            font-weight: bold;
            cursor: pointer;
            width: 35%;
        }

        /* Submit Button Hover Effect */
        .login-box input[type="submit"]:hover {
            background-color: #004d1b;
        }

        /* Focus Effect */
        .login-box input:focus {
            border-color: #004d1b;
        }

        /* Alert Styling */
        .alert {
            color: red;
            font-weight: bold;
        }

    </style>
</head>
<body><br><br><br>
    <h1>User Login</h1>
    <div class="login-box">
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <br><input type="password" name="password" placeholder="Password" required>
            <br><input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
