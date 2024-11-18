<?php
session_start();
require_once "config.php"; // Include your database connection

// Check user role
$user_role = $_SESSION['user_role'] ?? 'USER'; // Default to 'USER' if not set
$user_name = $_SESSION['user_name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $asset_number  = $_POST['asset_number'];
    $serial_number = $_POST['serial_number'];
    $type          = $_POST['type'];
    $manufacturer  = $_POST['manufacturer'];
    $year_model    = $_POST['year_model'];
    $description   = $_POST['description'];
    $department    = $_POST['department'];
	$branch        = $_POST['branch'];
    $status        = 'WORKING';      // Default status
 			
					
	$sql = "select * from tblequipments where assetnumber = ? and serialnumber = ? ";
    if ($stmt = mysqli_prepare($link, $sql)) 
	{
        mysqli_stmt_bind_param($stmt, "ss", $asset_number, $serial_number );
        mysqli_stmt_execute($stmt); 
		$result = mysqli_stmt_get_result($stmt);
        while ($accounts = mysqli_fetch_assoc($result)) 
		{
			echo "<script>alert('Equipment already exist !'); window.location.href='equipment.php';</script>";
			die();
		}
    }
	
   
	
    // Insert equipment into the database
    $sql = "INSERT INTO tblequipments (assetnumber, serialnumber, type, manufacturer, yearmodel, description, branch, department, status, createdby, datecreated  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssssssss", $asset_number, $serial_number, $type, $manufacturer, $year_model, $description, $branch, $department, $status, $$user_name, $datecreated );
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Equipment added successfully!'); window.location.href='equipment.php';</script>";
        } else {
            echo "<script>alert('Error adding equipment.');</script>";
        }
    }
	
	$date = date("Y-m-d");
    $time = date("Y-m-d H:i:s");
	$action = 'ADD';
	$module = 'EQUIPMENT';
	#create logs
	$sql = "INSERT INTO tbllogs ( datelog,timelog,performedby,`action`,module ) VALUES ( ?,?,?,?,?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssss",  $date  ,  $time    , $user_name, $action , $module );
		 if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Equipment added successfully!'); window.location.href='equipment.php';</script>";
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
	     table {
            margin: 20px auto;
            width: 50%;
            border: 5px solid #802306;
            border-radius: 10px;
            overflow: hidden;
        }
		
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://thumbs.dreamstime.com/z/cybernetic-data-analytics-computer-science-future-coding-wallpaper-ai-robot-algorithms-155190397.jpg');
            background-size: cover;
            color:black; font-size: 20px; font-weight: bold; /* Dark green text */
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
        input, select, textarea {
            margin: 10px;
            padding: 10px;
            border: 2px solid #006400;
            border-radius: 5px;
            font-weight: bold;
        }
        input[type="submit"], button {
            background-color: #C781A4;
            color: black;
            border: 5px solid #802306;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
        }
        input[type="submit"]:hover {
            background-color: #005700;
        }
		
		#integerInput {
			width: 100px; /* Adjust width as needed */
			padding: 5px;
			border: 1px solid #ccc;
			border-radius: 4px;
		}

		#integerInput:invalid {
			border-color: red;
		}

		#integerInput:valid {
			border-color: green;
		}


    </style>
</head>
<body>

     <br><br><br><br><h1>Equipment Management System</h1> 
    <h3>Add New Equipment  </h3> 
    <form method="POST">
	
	     <table border = 1 >
	       
	     <tbody>
		   <tr>
		     <td> Asset Number </td>
             <td > <input type="text" name="asset_number" placeholder="Asset Number" required> </td> 
		   </tr>
		   <tr>
		     <td>  Serial_number </td>
             <td > <input type="text" name="serial_number" placeholder="Serial Number" required> </td> 
		   </tr>
		    <tr>
		     <td>  Equipment Type </td>
             <td > 
    			  <select name="type" required    >
						<option value="">Select Type</option>
						<option value="Monitor">Monitor</option>
						<option value="CPU">CPU</option>
						<option value="Keyboard">Keyboard</option>
						<option value="Mouse">Mouse</option>
						<option value="AVR">AVR</option>
						<option value="MAC">MAC</option>
						<option value="Printer">Printer</option>
						<option value="Projector">Projector</option>
			     </select>
		     </td> 
		   </tr>
		   <tr>
		     <td>  Manufacturer </td>
             <td >   <input type="text" name="manufacturer" placeholder="Manufacturer" required>  </td> 
		   </tr>
		   <tr>
		     <td>  Year Model </td>
             <td >  <input type="number" name="year_model" id="integerInput" min="1000" max="9999" oninput="this.value = this.value.slice(0, 4);" title="Please enter exactly 4 digits"> </td> 
		   </tr>
		    <tr>
		     <td>  Description </td>
             <td > 	<textarea name="description" placeholder="Description" required></textarea> </td> 
		   </tr>
		   <tr>
		    <tr>
		     <td>  Branch </td>
              <td > 	 
			  <select name="branch" required>
				<option value="">CHOOSE BRANCH </option>
				<option value="LEGARDA">LEGARDA</option>
				<option value="PASAY">PASAY</option> 
				<option value="PASIG">PASIG</option>  
				<option value="MALABON">MALABON</option> 
				<option value="MANDALUYONG">MANDALUYONG</option>  
			  </select>
			 </tr>
		   <tr>
		     <td>  Department </td>
             <td >   <input type="text" name="department" placeholder="department" required>  </td> 
		   </tr>
		   <tr>
		   	<tr>
		     <td>  Status </td>
		      <td>
		   	  <select name="status" required>
            	<option value="">status</option>
                <option value="Working">Working</option>
				<option value="On-repair">On-repair</option>
				<option value="Retired">Retired</option>
              </select> 
             </tr>
		 <!--  <tr>
		     <td>  createdby </td>
             <td >   <input type="text" name="creaedby" placeholder="createdby" required>  </td> 
		   </tr>
		   <tr>
		   	 <td>  date created </td>
             <td >   <input type="text" name="date created" placeholder="date created" required>  </td> 
		   </tr>
		   <tr> -->
		     
		  </tbody>
	   </table>
	   
	     
        <input type="submit" value="Add Equipment">
    </form>
    <a href="equipment.php" style="font-weight: bold; color: #802306;">Back to Equipment Management</a>
</body>
</html>