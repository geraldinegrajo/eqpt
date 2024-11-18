<?php
session_start();
require_once "config.php"; // Include your database connection

// Check user role
$user_role = $_SESSION['user_role'] ?? 'USER'; // Default to 'USER' if not set
$user_name =  $_SESSION['user_name'] ; 

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
            background-image:  url('https://thumbs.dreamstime.com/z/cybernetic-data-analytics-computer-science-future-coding-wallpaper-ai-robot-algorithms-155190397.jpg');
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
            width: 33%;
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
            color: black;
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
            border: 2px solid #006400;
            border-radius: 5px;
            font-weight: bold;
        }
        input[type="submit"], button {
            background-color: #006400; /* Green button */
            color: white;
            border: none;
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
    <br><br><br><br><br><br><br><br><br><br><br><br><br><h1>Equipment Management System</h1><br><br>

	 <table>
	  <tbody>
	        <tr>
                <th>Welcome <?php  echo $user_name.'-'.$user_role  ?>  </th>
                
            </tr>
			<tr>
                <th>Module Access : </th>
                
            </tr>
			
            <?php
            
			if($user_role == 'ADMIN')
			{
				 echo "<tr> 
				            <td>  <a href='accounts.php ' style='color: #004d00;'>Accounts</a> </td>
					  </tr>
					  
					  <tr> 
				            <td>  <a href='equipment.php ' style='color: #004d00;'>Equipments</a> </td>
					  </tr>
					  
					  <tr> 
				            <td>  <a href='viewlogs.php ' style='color: #004d00;'>Logs </a> </td>
					  </tr>
					  
					  ";
			}	
			else if($user_role == 'TECHNICAL')
			{
				 echo " 
					  
					  <tr> 
				            <td>  <a href='equipment.php ' style='color: #004d00;'>Equipments</a> </td>
					  </tr>
					  
					  
					  
					  ";
			}	
			
            else if($user_role == 'USER')
			{
				 
				 echo " 
					  <tr> 
				            <td>  <a href='equipment.php ' style='color: #004d00;'>Equipments</a> </td>
					  </tr>
					 
					  
					  ";
		
			} 			
			
			 echo " 
					  <tr> 
				            <td>  <a href='login.php?action=logout ' style='color: #004d00;'>Log out</a> </td>
					  </tr>
					 
					  
					  ";
            ?>
        </tbody>
      </table>
    <footer>
        <br><p style="color: #802306; font-size: 18px; font-weight: bold;">&copy; 2024 Equipment Management System</p>
    </footer>
</body>
</html>