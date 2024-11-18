<?php
session_start();
require_once "config.php"; // Include your database connection

// Check user role
$user_role = $_SESSION['user_role'] ?? 'USER'; // Default to 'USER' if not set
$user_name = $_SESSION['user_name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role     = $_POST['role'];
    $email    = $_POST['email'];
    $status   = $_POST['status']; 
	$time     = date("Y-m-d H:i:s");

    // Update equipment in the database
    $sql = "UPDATE tblaccounts SET password=?, usertype =?, email=?, status=?  WHERE username=?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssss", $password, $role, $email, $status, $username);
        if (mysqli_stmt_execute($stmt)) {
            
        } else {
            echo "<script>alert('Error updating accounts.');</script>";
        }
    }
	
	
	$date = date("Y-m-d");
    $time = date("Y-m-d H:i:s");
	$action = 'UPDATE';
	$module = 'ACCOUNT';
	#create logs
	$sql = "INSERT INTO tbllogs ( datelog,timelog,performedby,`action`,module ) VALUES ( ?,?,?,?,?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssss",  $date  ,  $time    , $user_name, $action , $module );
		 if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Accounts added successfully!'); window.location.href='accounts.php';</script>";
        } else {
            echo "<script>alert('Error adding Accounts.');</script>";
        }
         
    }
	
	
}

// Fetch the current equipment details
$username = $_GET['username'] ?? '';
$sql = "SELECT * FROM tblaccounts  WHERE username  = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $accounts = mysqli_fetch_assoc($result);
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
            background-image: url('https://thumbs.dreamstime.com/z/cybernetic-data-analytics-computer-science-future-coding-wallpaper-ai-robot-algorithms-155190397.jpg');
            background-size: cover;
            color: #802306; /* Dark green text */
            text-align: center;
            font-size: 20px;
        }
        h1 {
            padding: 12px;
            margin: 25px auto;
            border: 15px solid #716713;
            border-radius: 15px;
            width: 750px;
            font-weight: bold;
            font-size: 45px;
            color: #802306; /* Darker green for headings */
        }
        input, select, textarea {
            margin: 10px;
            padding: 10px;
            border: 5px solid #802306;
            border-radius: 5px;
            font-weight: bold;
        }
        input[type="submit"], button {
            background-color: #C781A4;
            color: black;
            border: 5px solid #802306;
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
     <br><br><br><br> <br><br><br><br> <br><br><br><br> <h1>Equipment Management System</h1> 
      <h3>Update Account  </h3> 
    <form method="POST">
        <input type="text" name="username" placeholder="Username" value="<?php echo htmlspecialchars($accounts['username']); ?>"  required>
        <input type="text" name="password" placeholder="Password" value="<?php echo htmlspecialchars($accounts['password']); ?>"  required>
        <select name="role" required>
		    <option value="<?php echo htmlspecialchars($accounts['usertype']); ?>"><?php echo htmlspecialchars($accounts['usertype']); ?></option>
            <option value="ADMIN">ADMIN</option>
            <option value="USER">USER</option>
            <option value="TECHNICAL">TECHNICAL</option> 
        </select>
        <input type="text" name="email" placeholder="email" value="<?php echo htmlspecialchars($accounts['email']); ?>" required>
        <select name="status" required>
            <option value="<?php echo htmlspecialchars($accounts['status']); ?>"><?php echo htmlspecialchars($accounts['status']); ?></option> 
            <option value="Active">Active</option>
            <option value="DISABLED">DISABLED</option> 
        </select>  
        <input type="submit" value="Update Account"> 
    </form>
    <br><br><br><br><br><a href="accounts.php" style="color: #802306; font-size: 23px; font-weight: bold;">Back to Account Management</a>
</body>
</html>
