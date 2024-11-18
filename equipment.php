<?php
session_start();
require_once "config.php"; // Include your database connection

// Check user role
$user_role = $_SESSION['user_role'] ?? 'USER'; // Default to 'USER' if not set

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://thumbs.dreamstime.com/z/cybernetic-data-analytics-computer-science-future-coding-wallpaper-ai-robot-algorithms-155190397.jpg');
            background-size: cover;
            color: #006400; /* Dark green text */
            text-align: center;
        }
        h1 {
            padding: 12px;
            margin: 25px auto;
            border: 15px solid #716713;
            border-radius: 15px;
            width: 750px;
            font-weight: bold;
            font-size: 45px;
            margin-top: 5px;
            color: #802306; /* Darker green for headings */
        }
        table {
            margin: 20px auto;
            width: 85%;
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
            border: 5px solid #802306;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #006400;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }
        th {
            background-color: #006400; /* Green header */
            color: white;
        }
        tr:nth-child(even) {
            background-color: #e0f8e0; /* Light green for even rows */
        }
        tr:hover {
            background-color: #c1f0c1; /* Lighter green on hover */
        }
        input, select, textarea {
            margin: 10px;
            padding: 10px;
            background-color: #C781A4;
            border: 3px solid #802306;
            border-radius: 5px;
            font-weight: bold;
        }
        input[type="submit"], button {
            background-color: #C781A4;
            color: black;
            border: 3px solid #802306;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #005700; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <br><br><br><br><br><br><br><br><br><br><br><br><h1>Equipment Management System</h1><br><br>

    <form method="POST">
        <input type="text" name="search" placeholder="Search by Asset Number, Serial Number, Type, Department">
        <input type="submit" name="btnsearch" value="Search">
        <?php if ($user_role == 'ADMIN' || $user_role == 'TECHNICAL'): ?>
            <a href="add-equipment.php" style="font-weight: bold; color: #802306;">Add Equipment</a>
        <?php endif; ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="mainmenu.php" style="font-weight: bold; color: #802306;">Back to Main Menu</a> 
    </form>

    <table>
        <thead>
            <tr>
                <th>Asset Number</th>
                <th>Serial Number</th>
                <th>Type</th>
                <th>Manufacture</th>
                <th>Year Model</th>
                <th>Description</th>
                <th>Branch</th>
                <th>Department</th>
                <th>Status</th>
                <th>Createby</th>
                <th>Date Created</th>
                <?php if ($user_role == 'ADMIN' || $user_role == 'TECHNICAL'): ?>
                    <th>Action</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            // Search logic
            $search = isset($_POST['search']) ? $_POST['search'] : '';
            $sql = "SELECT * FROM tblEquipments WHERE assetnumber LIKE ? OR serialnumber LIKE ? OR type LIKE ? OR department LIKE ?";
            $searchValue = "%" . $search . "%";
            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssss", $searchValue, $searchValue, $searchValue, $searchValue);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                while ($equipment = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($equipment['assetnumber']) . "</td>";
                    echo "<td>" . htmlspecialchars($equipment['serialnumber']) . "</td>";
                    echo "<td>" . htmlspecialchars($equipment['type']) . "</td>";
					echo "<td>" . htmlspecialchars($equipment['manufacturer']) . "</td>";
                    echo "<td>" . htmlspecialchars($equipment['yearmodel']) . "</td>";
					echo "<td>" . htmlspecialchars($equipment['description']) . "</td>";
					echo "<td>" . htmlspecialchars($equipment['branch']) . "</td>";
					echo "<td>" . htmlspecialchars($equipment['department']) . "</td>";
					
                    echo "<td>" . htmlspecialchars($equipment['status']) . "</td>";
					echo "<td>" . htmlspecialchars($equipment['createdby']) . "</td>";
					echo "<td>" . htmlspecialchars($equipment['datecreated']) . "</td>";
                    if ($user_role == 'ADMIN' || $user_role == 'TECHNICAL') {
                        echo "<td>
                                <a href='update-equipment.php?asset_number=" . urlencode($equipment['assetnumber']) . "' style='color: #004d00;'>Edit</a>
                                <a href='delete-equipment.php?asset_number=" . urlencode($equipment['assetnumber']) . "' style='color: #ff0000;'>Delete</a>
                              </td>";
                    }
                    echo "</tr>";
                }
            }
            ?>
			
			
        </tbody>
		
		
		 
    </table>
    <footer>
        <br><br><p style="color: #802306; font-size: 20px; font-weight: bold;">&copy; 2024 Equipment Management System</p>
    </footer>
</body>
</html>