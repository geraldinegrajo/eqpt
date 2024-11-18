<?php
session_start();
require_once "config.php"; // Include your database connection

// Check user role
$user_role = $_SESSION['user_role'] ?? 'USER'; // Default to 'USER' if not set
$user_name = $_SESSION['user_name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $status = $_POST['status']; 
	$time = date("Y-m-d H:i:s");
	
	
   
	
    // Insert equipment into the database
    $sql = "INSERT INTO tblaccounts (username, password, usertype, email, status, createdby, datecreated ) VALUES (?, ?, ?, ?, ?, ?, ? )";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssss", $username, $password, $role, $email, $status, $user_name, $time );
        if (mysqli_stmt_execute($stmt)) {
            
        } else {
            echo "<script>alert('Error adding equipment.');</script>";
        }
    }
	
	$date = date("Y-m-d");
    $time = date("Y-m-d H:i:s");
	$action = 'ADD';
	$module = 'ACCOUNT';
	#create logs
	$sql = "INSERT INTO tbllogs ( datelog,timelog, performedby,`action`,module ) VALUES ( ?,?,?,?,?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssss",  $date  ,  $time    , $user_name, $action , $module );
		 if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Account added successfully!'); window.location.href='accounts.php';</script>";
        } else {
            echo "<script>alert('Error adding equipment.');</script>";
        }
         
    }
	
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://thumbs.dreamstime.com/b/database-concept-database-digital-data-paper-background-database-concept-painted-multicolor-text-database-digital-data-paper-107428790.jpg');
            background-size: cover;
            color: #006400; /* Dark green text */
            text-align: center;
        }
        h1 {
            font-weight: bold;
            color: #004d00;
        }
        input, select, textarea {
            margin: 10px;
            padding: 10px;
            border: 2px solid #006400;
            border-radius: 5px;
            font-weight: bold;
        }
        input[type="submit"], button {
            background-color: #006400;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
        }
        input[type="submit"]:hover {
            background-color: #005700;
        }
    </style>
</head>
<body>
    <br><br><br><br> <h1>Equipment Management System</h1> 
      <h3>Add New Account  </h3> 
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="text" name="password" placeholder="Password" required>
        <select name="role" required>
            <option value="">Select Type</option>
            <option value="ADMIN">ADMIN</option>
            <option value="USER">USER</option>
            <option value="TECHNICAL">TECHNICAL</option> 
        </select>
        <input type="text" name="email" placeholder="email" required>
        <select name="status" required>
            <option value="">Select status</option>
            <option value="Active">Active</option>
            <option value="DISABLED">DISABLED</option> 
        </select>  
        <input type="submit" value="Add Account">
    </form>
    <a href="accounts.php" style="font-weight: bold; color: #004d00;">Back to Account Management</a>
</body>
</html>