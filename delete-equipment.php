<?php
session_start();
require_once "config.php"; // Include your database connection

// Check user role
$user_role = $_SESSION['user_role'] ?? 'USER'; // Default to 'USER' if not set
$user_name = $_SESSION['user_name'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $asset_number = $_POST['asset_number']; 

    // Update equipment in the database
    $sql = "delete from tblequipments   WHERE assetnumber=?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s",  $asset_number);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Equipment deleted successfully!'); window.location.href='equipment.php';</script>";
        } else {
            echo "<script>alert('Error deleted equipment.');</script>";
        }
    }
	
	$date = date("Y-m-d");
    $time = date("Y-m-d H:i:s");
	$action = 'DELETE';
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
    <title>DELETE  Equipment</title>
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
     <br><br> <h1>Equipment Management System</h1> 
    <h3>Delete Equipment  </h3> 
    <form method="POST">
	   <table border = 1 >
	      <input type="hidden" name="asset_number" value="<?php echo htmlspecialchars($equipment['assetnumber']); ?>" >
	     <tbody>
		   <tr>
		     <td> Asset Number </td>
             <td >  <input disabled  disabled type="text" name="asset_number_display" value="<?php echo htmlspecialchars($equipment['assetnumber']);  ?>"></td> 
		   <tr>
		   <tr>
		     <td>  Serial number </td>
             <td >  <input type="text" name="serial_number" value="<?php echo htmlspecialchars($equipment['serialnumber']); ?>" required disabled > </td> 
		   <tr>
		    <tr>
		     <td>  Equipment Type </td>
             <td > 
    			  <select name="type" required disabled align = "left"  >
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
		     <td>  Manufacturer </td>
             <td >  <input type="text" name="manufacturer" value="<?php echo htmlspecialchars($equipment['manufacturer']); ?>" required disabled ></td> 
		   <tr>
		   <tr>
		     <td>  Year model </td>
             <td >  <input type="text" name="year_model" align = "left"  value="<?php echo htmlspecialchars($equipment['yearmodel']); ?>" required disabled ></td> 
		   <tr>
		    <tr>
		     <td>  Description </td>
             <td > 	<textarea name="description" required disabled align = "left" ><?php echo htmlspecialchars($equipment['description']); ?></textarea></td> 
		   <tr>
		   <tr>
		     <td>  Department </td>
             <td > 	<textarea name="department" required disabled align = "left" ><?php echo htmlspecialchars($equipment['department']); ?></textarea></td> 
		   <tr>
		   <tr>
		    <tr>
		     <td>  Branch </td>
              <td > 	 <select name="department" required disabled >
				<option value="<?php echo htmlspecialchars($equipment['branch']); ?>"><?php echo htmlspecialchars($equipment['branch']); ?></option>
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
              <td > 	<select name="status" required disabled >
				<option value="<?php echo htmlspecialchars($equipment['status']); ?>"><?php echo htmlspecialchars($equipment['status']); ?></option>
				<option value="Working">Working</option>
				<option value="On-repair">On-repair</option>
				<option value="Retired">Retired</option>
			</select>
			  </td> 
		   <tr>
		  </tbody>
	   </table>
			 
			
		 <input type="submit" value="Delete Equipment">
    </form>
    <a href="equipment.php" style="font-weight: bold; color: #004d00;">Back to Equipment Management</a>
</body>


 
</html>
