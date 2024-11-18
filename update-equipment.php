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
    $status        = $_POST['status'];
	$datetime      = date("Y-m-d H:i:s");

    // Update equipment in the database
    $sql = "UPDATE tblequipments SET serialnumber=?, type=?, manufacturer=?, yearmodel=?, description=?, department=?, status=? , branch = ? , createdby = ? , datecreated = ?  WHERE assetnumber=?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssssssss", $serial_number, $type, $manufacturer, $year_model, $description, $department, $status,  $branch  , $user_name , $datetime ,  $asset_number);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Equipment updated successfully!'); window.location.href='equipment.php';</script>";
        } else {
            echo "<script>alert('Error updating equipment.');</script>";
        }
    }
	
	
	$date = date("Y-m-d");
    $time = date("Y-m-d H:i:s");
	$action = 'UPDATE';
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

// Fetch the current equipment details
$asset_number = $_GET['asset_number'] ?? '';
$sql = "SELECT * FROM tblequipments WHERE assetnumber = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "s", $asset_number);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $equipment = mysqli_fetch_assoc($result);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Equipment</title>
    <style>
	    table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 50%;
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
            border: 2px solid #006400;
            border-radius: 10px;
            overflow: hidden;
        }
        body {
            font-family: Arial, sans-serif;
            background-image: uurl('https://thumbs.dreamstime.com/z/cybernetic-data-analytics-computer-science-future-coding-wallpaper-ai-robot-algorithms-155190397.jpg');
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
     <br><br> <h1>Equipment Management System</h1> 
    <h3>Update Equipment  </h3> 
    <form method="POST">
	   <table border = 1 >
	      <input type="hidden" name="asset_number" value="<?php echo htmlspecialchars($equipment['assetnumber']); ?>">
	     <tbody>
		   <tr>
		     <td> Asset Number </td>
             <td >  <input disabled  type="text" name="asset_number_display" value="<?php echo htmlspecialchars($equipment['assetnumber']);  ?>"></td> 
		   <tr>
		   <tr>
		     <td>  serial_number </td>
             <td >  <input type="text" name="serial_number" value="<?php echo htmlspecialchars($equipment['serialnumber']); ?>" required> </td> 
		   <tr>
		    <tr>
		     <td>  Equipment Type </td>
             <td > 
    			  <select name="type" required align = "left"  >
						<option value="<?php echo htmlspecialchars($equipment['type']); ?>"><?php echo htmlspecialchars($equipment['type']); ?></option>
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
		   <tr>
		   <tr>
		     <td>  manufacturer </td>
             <td >  <input type="text" name="manufacturer" value="<?php echo htmlspecialchars($equipment['manufacturer']); ?>" required></td> 
		   <tr>
		   <tr>
		     <td>  YEAR MODEL </td>
             <td >  
			        <input type="number" name="year_model" id="integerInput" min="1000" max="9999" oninput="this.value = this.value.slice(0, 4);" title="Please enter exactly 4 digits"  required > </td> 
			 
			 </td> 
		   <tr>
		    <tr>
		     <td>  description </td>
             <td > 	<textarea name="description" required align = "left" ><?php echo htmlspecialchars($equipment['description']); ?></textarea></td> 
		   <tr>
		   <tr>
		     <td>  description </td>
             <td > 	<textarea name="department" required align = "left" ><?php echo htmlspecialchars($equipment['department']); ?></textarea></td> 
		   <tr>
		   <tr>
		    <tr>
		     <td>  Branch </td>
              <td > 	 <select name="branch" required>
				<option value="<?php echo htmlspecialchars($equipment['branch']); ?>"><?php echo htmlspecialchars($equipment['branch']); ?></option>
				<option value="">CHOOSE BRANCH </option>
				<option value="LEGARDA">LEGARDA</option>
				<option value="PASAY">PASAY</option> 
				<option value="PASIG">PASIG</option>  
				<option value="MALABON">MALABON</option> 
				<option value="MANDALUYONG">MANDALUYONG</option>  
			</select>
			  </td> 
		   <tr>
		    <tr>
		     <td>  status </td>
              <td > 	<select name="status" required>
				<option value="<?php echo htmlspecialchars($equipment['status']); ?>"><?php echo htmlspecialchars($equipment['status']); ?></option>
				<option value="Working">Working</option>
				<option value="On-repair">On-repair</option>
				<option value="Retired">Retired</option>
			</select>
			  </td> 
		   <tr>
		  </tbody>
	   </table>
			 
			
		 <input type="submit" value="Update Equipment">
    </form>
    <a href="equipment.php" style="font-weight: bold; color: #004d00;">Back to Equipment Management</a>
</body>
</html>
