<?php
session_start();
require_once "config.php"; // Include your database connection

// Check user role
$user_role = $_SESSION['user_role'] ?? 'USER'; // Default to 'USER' if not set
$user_name = $_SESSION['user_name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	/*$query = "SELECT * FROM tbllogs order by timelog desc  ";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_assoc($result)) 
	{
		$date = date("Y-m-d");
		$time = date("Y-m-d H:i:s");
		$action = 'DELETE ALL';
		$module = 'LOGS';
		#create logs
		$sql = "INSERT INTO tbllogs ( datelog,timelog,performedby,`action`,module ) VALUES ( ?,?,?,?,?)";
		if ($stmt = mysqli_prepare($link, $sql)) {
			mysqli_stmt_bind_param($stmt, "sssss",  $date  ,  $time    , $user_name, $action , $module );
			 if (mysqli_stmt_execute($stmt)) {
				echo "<script>alert('All Logs deleted successfully!'); window.location.href='viewlogs.php';</script>";
			} else {
				echo "<script>alert('Error adding equipment.');</script>";
			}
			 
		}
    } */ 
	
	$query = "DELETE FROM  tbllogs  ";
    $result = mysqli_query($link, $query); 
	
	$date = date("Y-m-d");
	$time = date("Y-m-d H:i:s");
	$action = 'DELETE ALL';
	$module = 'LOGS';
	#create logs
	$sql = "INSERT INTO tbllogs ( datelog,timelog,performedby,`action`,module ) VALUES ( ?,?,?,?,?)";
	if ($stmt = mysqli_prepare($link, $sql)) 
	{
		mysqli_stmt_bind_param($stmt, "sssss",  $date  ,  $time    , $user_name, $action , $module );
		if (mysqli_stmt_execute($stmt)) {
				echo "<script>alert('All Logs deleted successfully!'); window.location.href='viewlogs.php';</script>";
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
    <title>Equipment Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://thumbs.dreamstime.com/z/cybernetic-data-analytics-computer-science-future-coding-wallpaper-ai-robot-algorithms-155190397.jpg');
            background-size: cover;
            color:  #802306; /* Dark green text */
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
            color: #802306; /* Darker green for headings */
        }
        table {
            margin: 20px auto;
            width: 90%;
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
            border: 8px solid #802306;
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
            border: 2px solid #006400;
            border-radius: 5px;
            font-weight: bold;
        }
        input[type="submit"], button {
            background-color: #C781A4; /* Green button */
            color: black;
            border: none;
            padding: 10px 20px;
            border: 3px solid #802306;
            cursor: pointer;
            font-weight: bold;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #005700; /* Darker green on hover */
        }
    </style>
</head>
<body>
     <br><br><br><br><h1>Equipment Management System</h1><br><br>
   
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="mainmenu.php" style="font-weight: bold; font-size: 25px; color: #802306;">Back to Main Menu</a> 
	
	 <form method="POST">
    <table>
        <thead>
            <tr>
                <th>Counter</th>
                <th>Date Log</th>
                <th>Time Log</th>
                <th>Performed By</th>
                <th>Action</th>
                <th>Module</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //  
			$counter  = 0; 
			$query = "SELECT * FROM tbllogs order by timelog desc  ";
            $result = mysqli_query($link, $query);
            while ($row = mysqli_fetch_assoc($result)) 
			{
				$counter = $counter + 1;
               ?>
                   <tr>
                      <th class="font-weight-normal"><?php echo $counter  ?></th>
                      <th class="font-weight-normal"><?php echo $row["datelog"] ?></th>
                      <th class="font-weight-normal"><?php echo $row["timelog"] ?></th>
                      <th class="font-weight-normal"><?php echo $row["performedby"] ?></th>
                      <th class="font-weight-normal"><?php echo $row["action"] ?></th>
					  <th class="font-weight-normal"><?php echo $row["module"] ?></th>
                    </tr>            
              <?php
           } 
						
		  				
      
            ?>
			
			<input type="submit" value="Delete All Logs">
        </tbody>
		
		
		</form> 
    </table>
    <footer>
        <br><br><p style="color: #802306; font-size: 20px; font-weight: bold;">&copy; 2024 Equipment Management System</p>
    </footer>
</body>
</html>